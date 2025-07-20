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
            if (!current_user_can('edit_posts')) {
                wp_send_json_error();
            }

            $tab = $_GET['tab'];
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
            if (!current_user_can('edit_posts')) {
                wp_send_json_error();
            }

            $template = isset($_REQUEST['template']) ? $_REQUEST['template'] : false;
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
                $new_post = $term_ids = null;

                if ($template['elementor_page']) {
                    $new_post = array(
                        'post_type' => $template['type'],
                        'post_title' => $template['title'],
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
                        'post_type' => $template['type'],
                        'post_title' => $template['title'],
                        'post_status' => 'publish',
                        'post_content' => $content
                    );
                }

                if (isset($template['custom_taxonomy']) && !empty($template['custom_taxonomy'])) {
                    foreach ($template['custom_taxonomy'] as $tax) {
                        $taxonomy = $tax['taxonomy'];
                        if (taxonomy_exists($taxonomy)) {
                            $term_slugs = $tax['term_slug'];
                            foreach ($term_slugs as $slug) {
                                // Check if term exist for taxonomy
                                if (term_exists($slug, $taxonomy)) {
                                    $term_object = get_term_by('slug', $slug, $taxonomy);
                                    $term_id = $term_object->term_id;
                                } else {
                                    $insterm = wp_insert_term($slug, $taxonomy, array(
                                        'description' => '',
                                        'parent' => 0,
                                        'slug' => $slug,
                                    )
                                    );
                                    $term_id = $insterm['term_id'];
                                }
                                if ($term_id)
                                    $term_ids[] = $term_id;
                            }
                            $new_post_extra[$taxonomy] = $term_ids;
                        }
                    }
                }
                if (isset($new_post_extra)) {
                    $new_post['tax_input'] = $new_post_extra;
                }
                $post_id = wp_insert_post($new_post);

                // define file location
                $image_url = esc_url($template['template_featured_image']); // Define the image URL here

                if ($image_url) {
                    $image_name = basename($image_url);
                    $upload_dir = wp_upload_dir(); // Set upload folder
                    $image_data = file_get_contents($image_url); // Get image data
                    $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name
                    $filename = basename($unique_file_name); // Create image file name
                    // Check folder permission and define file location
                    if (wp_mkdir_p($upload_dir['path'])) {
                        $file = $upload_dir['path'] . '/' . $filename;
                    } else {
                        $file = $upload_dir['basedir'] . '/' . $filename;
                    }

                    // Create the image  file on the server
                    file_put_contents($file, $image_data);

                    // Check image file type
                    $wp_filetype = wp_check_filetype($filename, null);

                    // Set attachment data
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title' => sanitize_file_name($filename),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

                    // Create the attachment
                    $attach_id = wp_insert_attachment($attachment, $file, $post_id);

                    // Include image.php
                    if (!function_exists('wp_crop_image')) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                    }

                    // Define attachment metadata
                    $attach_data = wp_generate_attachment_metadata($attach_id, $file);

                    // Assign metadata to attachment
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    // And finally assign featured image to post
                    set_post_thumbnail($post_id, $attach_id);
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
            if (!isset($_POST['actions'])) {
                return;
            }

            $actions = json_decode(stripslashes($_REQUEST['actions']), true);
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
            $template = $this->get_template_data_array($_REQUEST);
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
