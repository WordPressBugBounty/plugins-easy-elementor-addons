<?php

namespace EEADElements\Templates\Classes;

use EEADElements\Templates;

if (!defined('ABSPATH'))
    exit;

if (!class_exists('EEAD_Templates_Manager')) {

    /**
     * EEAD Templates Manager.
     *
     * Templates manager class handles all templates library insertion
     *
     */
    class EEAD_Templates_Manager {

        private static $instance = null;
        private $sources = array();

        /**
         * Ht_Templates_Manager constructor.
         *
         * initialize required hooks for templates.
         *
         * @access public
         */
        public function __construct() {
            //Register AJAX hooks
            add_action('wp_ajax_eead_get_templates', array($this, 'get_templates'));
            add_action('wp_ajax_eead_inner_template', array($this, 'insert_inner_template'));

            if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '2.2.8', '>')) {
                add_action('elementor/ajax/register_actions', array($this, 'register_ajax_actions'), 20);
            } else {
                add_action('wp_ajax_elementor_get_template_data', array($this, 'get_template_data'), -1);
            }

            $this->register_sources();
            add_filter('eead-addons-core/assets/editor/localize', array($this, 'localize_tabs'));
        }

        /**
         * Localize tabs
         *
         * Add tabs data to localize object
         *
         * @access public
         *
         * @return [type] [description]
         */
        public function localize_tabs($data) {
            $tabs = $this->get_template_tabs();
            $ids = array_keys($tabs);
            $default = $ids[0];
            $data['tabs'] = $this->get_template_tabs();
            $data['defaultTab'] = $default;
            return $data;
        }

        /**
         * Register sources
         *
         * Register templates sources.
         *
         * @access public
         *
         * @return void
         */
        public function register_sources() {
            require EEAD_PATH . 'templates/sources/base.php';
            $namespace = str_replace('Classes', 'Sources', __NAMESPACE__);
            $sources = array(
                'eead' => $namespace . '\EEAD_Templates_Source_Api',
            );

            foreach ($sources as $key => $class) {
                require EEAD_PATH . 'templates/sources/' . $key . '.php';
                $this->add_source($key, $class);
            }
        }

        /**
         * Get template tabs
         *
         * Get tabs for the library.
         *
         * @access public
         */
        public function get_template_tabs() {
            $tabs = Templates\eead_elementor_templates()->types->get_types_for_popup();
            return $tabs;
        }

        /**
         * Get template tabs
         *
         * Get tabs for the library.
         *
         * @access public
         *
         * @param $key source key
         * @param $class source class
         */
        public function add_source($key, $class) {
            $this->sources[$key] = new $class();
        }

        /**
         * Returns needed source instance
         *
         * @return object
         */
        public function get_source($slug = null) {
            return isset($this->sources[$slug]) ? $this->sources[$slug] : false;
        }

        /**
         * Get template
         *
         * Get templates grid data.
         *
         * @access public
         */
        public function get_templates() {
            check_ajax_referer('eead_editor_nonce', 'nonce');

            if (!current_user_can('edit_posts')) {
                wp_send_json_error();
            }

            $tab = eead_get_var('tab');
            $tabs = $this->get_template_tabs();
            $sources = $tabs[$tab]['sources'];

            $result = array(
                'templates' => array(),
                'categories' => array(),
                'widgets' => array(),
            );

            foreach ($sources as $source_slug) {
                $source = isset($this->sources[$source_slug]) ? $this->sources[$source_slug] : false;
                if ($source) {
                    $result['templates'] = array_merge($result['templates'], $source->get_items($tab));
                    $result['categories'] = array_merge($result['categories'], $source->get_categories($tab));
                    $result['widgets'] = array_merge($result['widgets'], $source->get_widgets($tab));
                }
            }

            $all_cats = array(
                array(
                    'slug' => '',
                    'title' => esc_html__('All Sections', 'easy-elementor-addons'),
                ),
            );

            if (!empty($result['categories'])) {
                $result['categories'] = array_merge($all_cats, $result['categories']);
            }
            wp_send_json_success($result);
        }

        /**
         * Insert inner template
         *
         * Insert an inner template before insert the parent one.
         *
         * @access public
         */
        public function insert_inner_template() {
            check_ajax_referer('eead_editor_nonce', 'nonce');

            if (!current_user_can('edit_posts')) {
                wp_send_json_error();
            }

            $template = eead_get_request('template', 'sanitize_text_field', false);
            if (!$template) {
                wp_send_json_error();
            }

            $template_id = isset($template['template_id']) ? esc_attr($template['template_id']) : false;
            $source_name = isset($template['source']) ? esc_attr($template['source']) : false;
            $content = isset($template['content']) ? $template['content'] : false;

            $source = isset($this->sources[$source_name]) ? $this->sources[$source_name] : false;
            if (!$source || !$template_id) {
                wp_send_json_error();
            }

            if (!empty($content)) {
                $new_post = null;

                /*
                 * The post type arrives with the request and this handler is open to
                 * any role that can edit_posts, so the type has to be a real one and
                 * the caller has to actually hold the rights to it. Without this a
                 * Contributor could name any post type and have a post published on
                 * their behalf, which is not a capability that role has.
                 */
                $post_type = isset($template['type']) ? sanitize_key($template['type']) : '';
                $post_type_object = $post_type ? get_post_type_object($post_type) : null;

                if (!$post_type_object) {
                    wp_send_json_error();
                }

                if (!current_user_can($post_type_object->cap->create_posts) || !current_user_can($post_type_object->cap->publish_posts)) {
                    wp_send_json_error();
                }

                $post_title = isset($template['title']) ? $template['title'] : '';

                if (!empty($template['elementor_page'])) {
                    $new_post = array(
                        'post_type' => $post_type,
                        'post_title' => $post_title,
                        'post_status' => 'publish',
                        'meta_input' => array(
                            '_elementor_data' => $content,
                            '_elementor_edit_mode' => 'builder',
                            '_elementor_template_type' => 'section',
                            '_elementor_version' => defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : '3.12',
                        ),
                    );
                } else {
                    $new_post = array(
                        'post_type' => $post_type,
                        'post_title' => $post_title,
                        'post_status' => 'publish',
                        'post_content' => $content
                    );
                }

                if (isset($template['custom_taxonomy']) && !empty($template['custom_taxonomy'])) {
                    foreach ($template['custom_taxonomy'] as $tax) {
                        $taxonomy = isset($tax['taxonomy']) ? $tax['taxonomy'] : '';
                        $taxonomy_object = $taxonomy ? get_taxonomy($taxonomy) : false;

                        if ($taxonomy_object) {
                            // Reset per taxonomy, otherwise terms collected for an
                            // earlier taxonomy get assigned to this one as well.
                            $term_ids = array();
                            $term_slugs = isset($tax['term_slug']) ? (array) $tax['term_slug'] : array();

                            foreach ($term_slugs as $slug) {
                                $term_id = 0;

                                // Check if term exist for taxonomy
                                if (term_exists($slug, $taxonomy)) {
                                    $term_object = get_term_by('slug', $slug, $taxonomy);
                                    $term_id = $term_object ? $term_object->term_id : 0;
                                } elseif (current_user_can($taxonomy_object->cap->edit_terms)) {
                                    // Creating a term is its own capability, so never
                                    // create one for a user who does not hold it.
                                    $insterm = wp_insert_term($slug, $taxonomy, array(
                                        'description' => '',
                                        'parent' => 0,
                                        'slug' => $slug,
                                    )
                                    );
                                    $term_id = is_wp_error($insterm) ? 0 : $insterm['term_id'];
                                }

                                if ($term_id)
                                    $term_ids[] = $term_id;
                            }

                            if ($term_ids) {
                                $new_post_extra[$taxonomy] = $term_ids;
                            }
                        }
                    }
                }
                if (isset($new_post_extra)) {
                    $new_post['tax_input'] = $new_post_extra;
                }
                $post_id = wp_insert_post($new_post);

                $image_url = isset($template['template_featured_image']) ? esc_url_raw($template['template_featured_image']) : '';

                if ($image_url && $post_id && !is_wp_error($post_id)) {
                    /*
                     * Sideload rather than fetching the URL and writing the response
                     * into the uploads directory directly. media_sideload_image()
                     * rejects anything that is not an image extension, downloads via
                     * wp_safe_remote_get() so the URL cannot be aimed at internal
                     * hosts, and revalidates the real file type before storing.
                     *
                     * The previous file_get_contents()/file_put_contents() pair did
                     * none of that: wp_unique_filename() only de-duplicates a name, it
                     * does not reject an extension, so a caller-supplied .php URL was
                     * written verbatim into uploads and was executable on request.
                     */
                    // admin-ajax.php loads all three, but guard them separately so a
                    // missing one cannot be masked by another already being loaded.
                    if (!function_exists('media_sideload_image')) {
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                    }
                    if (!function_exists('download_url')) {
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                    }
                    if (!function_exists('wp_generate_attachment_metadata')) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                    }

                    $attach_id = media_sideload_image($image_url, $post_id, null, 'id');

                    if (!is_wp_error($attach_id)) {
                        set_post_thumbnail($post_id, $attach_id);
                    }
                }
            }
            wp_send_json_success();
        }

        /**
         * Register AJAX actions
         *
         * Add new actions to handle data after an AJAX requests returned.
         *
         * @access public
         */
        public function register_ajax_actions($ajax_manager) {
            if (!eead_get_post('actions')) {
                return;
            }

            $actions = json_decode(stripslashes(eead_get_request('actions')), true);
            $data = false;

            foreach ($actions as $id => $action_data) {
                if (!isset($action_data['get_template_data'])) {
                    $data = $action_data;
                }
            }

            if (!$data) {
                return;
            }

            if (!isset($data['data'])) {
                return;
            }

            if (!isset($data['data']['source'])) {
                return;
            }

            $source = $data['data']['source'];

            if (!$source && !isset($this->sources[$source])) {
                return;
            }

            $ajax_manager->register_ajax_action('get_template_data', function ($data) {
                return $this->get_template_data_array($data);
            });
        }

        /**
         * Get template data array
         *
         * triggered to get an array for a single template data
         *
         * @access public
         */
        public function get_template_data_array($data) {
            if (!current_user_can('edit_posts')) {
                return false;
            }

            if (empty($data['template_id'])) {
                return false;
            }

            $source_name = isset($data['source']) ? esc_attr($data['source']) : '';
            if (!$source_name) {
                return false;
            }

            $source = isset($this->sources[$source_name]) ? $this->sources[$source_name] : false;
            if (!$source) {
                return false;
            }

            if (empty($data['tab'])) {
                return false;
            }

            $template = $source->get_item($data['template_id'], $data['tab']);
            return $template;
        }

        /**
         * EEAD get template data
         *
         * trigger `get_template_data_array` after template insert
         *
         * @access public
         */
        public function get_template_data() {
            $template = $this->get_template_data_array(array(
                'template_id' => eead_get_request('template_id'),
                'source' => eead_get_request('source'),
                'tab' => eead_get_request('tab'),
            ));
            if (!$template) {
                wp_send_json_error();
            }
            wp_send_json_success($template);
        }

        /**
         * Returns the instance.
         *
         * @since  3.6.0
         * @return object
         */
        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if (null == self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }

    }

}
