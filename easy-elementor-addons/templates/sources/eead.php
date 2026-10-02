<?php

namespace EEADElements\Templates\Sources;

use EEADElements\Templates;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class EEAD_Templates_Source_Api extends EEAD_Templates_Source_Base {

    /**
     * Source version, memoized for the request.
     *
     * @var string|null
     */
    private $version = null;

    /**
     * Return source slug.
     *
     * @access public
     */
    public function get_slug() {
        return 'eead';
    }

    /**
     * Return source version.
     *
     * @access public
     */
    public function get_version() {
        if (null !== $this->version) {
            return $this->version;
        }

        $key = $this->get_slug() . '_version';
        $version = get_transient($key);

        if (false === $version) {
            $version = (string) Templates\eead_elementor_templates()->api->get_info('api_version');
            // A failed lookup is kept briefly so an unreachable API is not
            // queried on every request.
            set_transient($key, $version, $version ? DAY_IN_SECONDS : HOUR_IN_SECONDS);
        }

        $this->version = $version;
        return $this->version;
    }

    /**
     * Return cached items list
     *
     * @access public
     */
    public function get_items($tab = null) {
        if (!$tab) {
            return array();
        }

        $cached = $this->get_templates_cache();
        if (!empty($cached[$tab])) {
            return $this->prepare_items(array_values($cached[$tab]));
        }

        $templates = $this->remote_get_templates($tab);
        if (!$templates) {
            return array();
        }

        if (empty($cached)) {
            $cached = array();
        }

        $cached[$tab] = $templates;

        $this->set_templates_cache($cached);
        return $this->prepare_items($templates);
    }

    /**
     * Prepare items for response
     *
     * Titles arrive HTML-encoded (e.g. `&#8211;`) and the modal prints them
     * escaped, so decode them to plain text here.
     *
     * @param array $templates templates list.
     *
     * @return array
     */
    public function prepare_items($templates) {
        foreach ($templates as $key => $template) {
            if (isset($template['title']) && is_string($template['title'])) {
                $templates[$key]['title'] = html_entity_decode($template['title'], ENT_QUOTES, 'UTF-8');
            }
        }
        return $templates;
    }

    /**
     * Get templates from remote server
     *
     * @param  string $tab tab slug.
     *
     * @return array
     */
    public function remote_get_templates($tab) {
        $api_url = Templates\eead_elementor_templates()->api->api_url('templates');

        if (!$api_url) {
            return false;
        }

        $response = wp_remote_get($api_url . $tab, array(
            'timeout' => 15
        ));

        $body = wp_remote_retrieve_body($response);

        if (!$body) {
            return false;
        }

        $body = json_decode($body, true);
        if (!isset($body['success']) || true !== $body['success']) {
            return false;
        }

        if (empty($body['templates'])) {
            return false;
        }

        return $body['templates'];
    }

    /**
     * Get categories from remote server
     *
     * @param  string $tab tab slug.
     *
     * @return array
     */
    public function remote_get_categories($tab) {
        $api_url = Templates\eead_elementor_templates()->api->api_url('categories');
        if (!$api_url) {
            return false;
        }

        $response = wp_remote_get($api_url . $tab, array(
            'timeout' => 15
        ));

        $body = wp_remote_retrieve_body($response);

        if (!$body) {
            return false;
        }

        $body = json_decode($body, true);

        if (!isset($body['success']) || true !== $body['success']) {
            return false;
        }

        if (empty($body['terms'])) {
            return false;
        }

        return $body['terms'];
    }

    /**
     * Get widgets from remote server
     *
     * @param string $tab tab slug.
     *
     * @return array
     */
    public function remote_get_widgets($tab) {
        $api_url = Templates\eead_elementor_templates()->api->api_url('widgets');

        if (!$api_url) {
            return false;
        }

        $response = wp_remote_get($api_url . $tab, array(
            'timeout' => 15
        ));

        $body = wp_remote_retrieve_body($response);

        if (!$body) {
            return false;
        }

        $body = json_decode($body, true);
        if (!isset($body['success']) || true !== $body['success']) {
            return false;
        }

        if (empty($body['terms'])) {
            return false;
        }
        return $body['terms'];
    }

    /**
     * Return source item list
     *
     * @access public
     */
    public function get_categories($tab = null) {
        if (!$tab) {
            return array();
        }

        $cached = $this->get_categories_cache();
        if (!empty($cached[$tab])) {
            return $this->prepare_categories($cached[$tab]);
        }

        $categories = $this->remote_get_categories($tab);
        if (!$categories) {
            return array();
        }

        if (empty($cached)) {
            $cached = array();
        }

        $cached[$tab] = $categories;
        $this->set_categories_cache($cached);
        return $this->prepare_categories($categories);
    }

    /**
     * Prepare categories for response
     *
     * @return [type] [description]
     */
    public function prepare_categories($categories) {
        $result = array();
        foreach ($categories as $slug => $title) {
            $result[] = array(
                'slug' => $slug,
                'title' => $title,
            );
        }
        return $result;
    }

    /**
     * Return source item list
     *
     * @access public
     */
    public function get_widgets($tab = null) {
        if (!$tab) {
            return array();
        }

        $cached = $this->get_widgets_cache();

        if (!empty($cached[$tab])) {
            return $cached[$tab];
        }

        $widgets = $this->remote_get_widgets($tab);
        if (!$widgets) {
            return array();
        }

        if (empty($cached)) {
            $cached = array();
        }

        $cached[$tab] = $widgets;
        $this->set_widgets_cache($cached);
        return $widgets;
    }

    /**
     * Return single item
     *
     * @access public
     */
    public function get_item($template_id, $tab = false) {
        $id = str_replace($this->id_prefix(), '', (string) $template_id);
        $id = is_numeric($id) ? absint($id) : rawurlencode(sanitize_key($id));
        if (!$id) {
            throw new \Exception(esc_html__('Invalid template.', 'easy-elementor-addons'));
        }

        if (!$tab) {
            $tab = eead_get_request('tab', 'sanitize_text_field', false);
        }

        $license_key = Templates\eead_elementor_templates()->config->get('key');
        $api_url = Templates\eead_elementor_templates()->api->api_url('template');
        if (!$api_url) {
            throw new \Exception(esc_html__('Template library is not available.', 'easy-elementor-addons'));
        }

        $request = add_query_arg(
            array(
                'license' => $license_key,
                'url' => urlencode(home_url('/')),
            ), $api_url . $id
        );

        $response = wp_remote_get($request, array(
            'timeout' => 15
        ));

        $body = wp_remote_retrieve_body($response);
        $body = json_decode($body, true);

        if (!isset($body['success'])) {
            throw new \Exception(esc_html__('Internal Error', 'easy-elementor-addons'));
        }

        $content = isset($body['content']) ? $body['content'] : '';
        $type = isset($body['type']) ? $body['type'] : '';
        $license = isset($body['license']) ? $body['license'] : '';

        if (!empty($content)) {
            $content = $this->replace_elements_ids($content);
            $content = $this->process_export_import_content($content, 'on_import');
        }

        return array(
            'page_settings' => array(),
            'type' => $type,
            'license' => $license,
            'content' => $content
        );
    }

    /**
     * Return transient lifetime
     *
     * @access public
     */
    public function transient_lifetime() {
        return DAY_IN_SECONDS;
    }

}
