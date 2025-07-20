<?php

namespace EEADElements\Templates\Classes;

use EEADElements\Templates;

if (!defined('ABSPATH'))
    exit; // No access of directly access

if (!class_exists('EEAD_Templates_Assets')) {

    /**
     * EEAD Templates Assets.
     *
     * EEAD Templates Assets class is responsible for enqueuing all required assets for integration templates on the editor page.
     *
     */
    class EEAD_Templates_Assets {
        /*
         * Instance of the class
         *
         * @access private
         */

        private static $instance = null;

        /**
         * EEAD_Templates_Assets constructor.
         *
         * Triggers the required hooks to enqueue CSS/JS files.
         *
         * @access public
         */
        public function __construct() {
            add_action('elementor/preview/enqueue_styles', array($this, 'enqueue_preview_styles'));
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'editor_scripts'), -1);
            add_action('elementor/editor/after_enqueue_styles', array($this, 'editor_styles'));
            add_action('elementor/editor/footer', array($this, 'load_footer_scripts'));
        }

        /**
         * Editor Styles
         *
         * Enqueue required editor CSS files.
         *
         * @access public
         */
        public function editor_styles() {
            wp_enqueue_style(
                'eead-editor-only', EEAD_URL . 'templates/assets/css/editor.css', [], EEAD_VERSION
            );
        }

        /**
         * Preview Styles
         *
         * Enqueue required templates CSS file.
         *
         * @access public
         */
        public function enqueue_preview_styles() {
            wp_enqueue_style(
                'eead-addons-editor-preview', EEAD_URL . 'templates/assets/css/preview.css', array(), EEAD_VERSION, 'all'
            );
        }

        /**
         * Editor Scripts
         *
         * Enqueue required editor JS files, localize JS with required data.
         *
         * @access public
         */
        public function editor_scripts() {
            wp_enqueue_script('eead-addons-editor-js', EEAD_URL . 'templates/assets/js/editor.js', array(
                'jquery',
                'underscore',
                'backbone-marionette'
            ), EEAD_VERSION, true
            );
            $button = Templates\eead_elementor_templates()->config->get('eead_elementor_templates');
            wp_localize_script('eead-addons-editor-js', 'EEADData', apply_filters('eead-addons-core/assets/editor/localize', array(
                'eead_image_dir' => EEAD_URL . 'templates/assets/images/hash-icon.svg',
                'EEADEditorBtn' => $button,
                'modalRegions' => $this->get_modal_region(),
                'license' => array(
                    'status' => Templates\eead_elementor_templates()->config->get('status'),
                    'activateLink' => Templates\eead_elementor_templates()->config->get('license_page'),
                    'proMessage' => Templates\eead_elementor_templates()->config->get('pro_message')
                ),
            ))
            );
        }

        /**
         * Get Modal Region
         *
         * Get modal region in the editor.
         *
         * @access public
         */
        public function get_modal_region() {
            return array(
                'modalHeader' => '.dialog-header',
                'modalContent' => '.dialog-message',
            );
        }

        /**
         * Add Templates Scripts
         *
         * Load required templates for the templates library.
         *
         * @access public
         */
        public function load_footer_scripts() {
            $scripts = glob(EEAD_PATH . 'templates/editor/*.php');
            array_map(function ($file) {
                $name = basename($file, '.php');
                ob_start();
                include $file;
                printf('<script type="text/html" id="views-eead-%1$s">%2$s</script>', $name, ob_get_clean());
            }, $scripts);
        }

        /**
         * Get Instance
         *
         * Creates and returns an instance of the class.
         *
         * @access public
         *
         * @return object
         */
        public static function get_instance() {
            if (self::$instance == null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

    }

}