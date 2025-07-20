<?php

namespace EEADElements\Templates;

use EEADElements\Templates\Types;

if (!defined('ABSPATH'))
    exit;

if (!class_exists('EEAD_Templates')) {

    class EEAD_Templates {

        private static $instance = null;
        public $api;
        public $config;
        public $assets;
        public $temp_manager;
        public $types;

        public function __construct() {
            add_action('init', array($this, 'init'));
        }

        public function init() {
            $this->load_files();
            $this->set_config();
            $this->set_assets();
            $this->set_api();
            $this->set_types();
            $this->set_templates_manager();
        }

        private function load_files() {
            require EEAD_PATH . 'templates/classes/config.php';
            require EEAD_PATH . 'templates/classes/assets.php';
            require EEAD_PATH . 'templates/classes/manager.php';
            require EEAD_PATH . 'templates/types/manager.php';
            require EEAD_PATH . 'templates/classes/api.php';
        }

        private function set_config() {
            $this->config = new Classes\EEAD_Templates_Core_Config();
        }

        private function set_assets() {
            $this->assets = new Classes\EEAD_Templates_Assets();
        }

        private function set_api() {
            $this->api = new Classes\EEAD_Templates_API();
        }

        private function set_types() {
            $this->types = new Types\EEAD_Templates_Types();
        }

        private function set_templates_manager() {
            $this->temp_manager = new Classes\EEAD_Templates_Manager();
        }

        public static function get_instance() {
            if (self::$instance == null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

    }

}

if (!function_exists('eead_elementor_templates')) {

    function eead_elementor_templates() {
        return EEAD_Templates::get_instance();
    }

}
eead_elementor_templates();
