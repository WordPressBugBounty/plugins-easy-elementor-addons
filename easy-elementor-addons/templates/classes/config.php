<?php

namespace EEADElements\Templates\Classes;

use EEADElements\Helper\EEAD_Helper;

if (!defined('ABSPATH'))
    exit; // No access of directly access

if (!class_exists('EEAD_Templates_Core_Config')) {

    /**
     * EEAD Templates Core config.
     *
     * Templates core class is responsible for handling templates library.
     *
     */
    class EEAD_Templates_Core_Config {
        /*
         * Instance of the class
         *
         * @access private
         *
         */

        private static $instance = null;

        /*
         * Holds config data
         *
         * @access private
         *
         */
        private $config;

        /**
         * EEAD_Templates_Core_Config constructor.
         *
         * Sets config data.
         *
         * @access public
         */
        public function __construct() {

            $this->config = array(
                'eead_elementor_templates' => esc_html__('EEAD Templates', 'easy-elementor-addons'),
                'key' => $this->get_license_key(),
                'status' => $this->get_license_status(),
                'license_page' => $this->get_license_page(),
                'pro_message' => $this->get_pro_message(),
                'api' => array(
                    'enabled' => true,
                    'base' => 'https://eea.hashcreation.com/',
                    'path' => 'wp-json/eead/v2',
                    'endpoints' => array(
                        'templates' => '/templates/',
                        'widgets' => '/widgets/',
                        'categories' => '/categories/',
                        'template' => '/template/',
                        'info' => '/info/'
                    ),
                )
            );
        }

        /**
         * Get license key.
         *
         * Gets EEAD Add-ons PRO license key.
         *
         * @access public
         *
         * @return string|boolean license key or false if no license key
         */
        public function get_license_key() {
            if (!defined('EEAD_VERSION')) {
                return;
            }
            $key = "";
            return $key;
        }

        /**
         * Get license status.
         *
         * Gets EEAD Add-ons PRO license status.
         *
         * @access public
         *
         * @return string|boolean license status or false if no license key
         */
        public function get_license_status() {
            if (!defined('EEAD_VERSION')) {
                return;
            }
            $status = 'zvalid';
            return $status;
        }

        /**
         * Get license page.
         *
         * Gets EEAD Add-ons PRO license page.
         *
         * @access public
         *
         * @return string admin license page or plugin URI
         */
        public function get_license_page() {
            return esc_url(admin_url('admin.php?page=eead-license-key'));
        }

        /**
         *
         * Get License Message
         *
         * @access public
         *
         * @return string Pro version message
         */
        public function get_pro_message() {
            return esc_html__('Get Pro', 'easy-elementor-addons');
        }

        /**
         * Get
         *
         * Gets a segment of config data.
         *
         * @access public
         *
         * @return string|array|false data or false if not set
         */
        public function get($key = '') {
            return isset($this->config[$key]) ? $this->config[$key] : false;
        }

        /**
         * Creates and returns an instance of the class
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