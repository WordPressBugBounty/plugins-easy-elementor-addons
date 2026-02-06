<?php

/**
 * Plugin Name: Easy Elementor Addons - Addons Pack for Elementor Page Builder
 * Plugin URI: https://demo.hashthemes.com/easy-elementor-addons/
 * Description: Level up with Easy Elementor Addons – adds powerful widgets and sleek design tools to your favorite Elementor page builder.
 * Version: 2.3.3
 * Author: HashThemes
 * Author URI: https://hashthemes.com/
 * Text Domain: easy-elementor-addons
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * Elementor tested up to: 3.32
 */
/* If this file is called directly, abort */
if (!defined('WPINC')) {
    die();
}

define('EEAD_VERSION', '2.3.3');

define('EEAD_FILE', __FILE__);
define('EEAD_PLUGIN_BASENAME', plugin_basename(EEAD_FILE));
define('EEAD_PATH', plugin_dir_path(EEAD_FILE));
define('EEAD_URL', plugins_url('/', EEAD_FILE));

define('EEAD_ASSETS_URL', EEAD_URL . 'assets/');

if (!class_exists('Easy_Elementor_Addons')) {

    class Easy_Elementor_Addons {

        private static $instance = NULL;

        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if (self::$instance == NULL) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {

            // Run On Plugin Activation 
            register_activation_hook(__FILE__, array($this, 'plugin_activation'));

            // Load necessary files.
            add_action('plugins_loaded', array($this, 'init'));
            add_filter('plugin_action_links_' . plugin_basename(EEAD_FILE), array($this, 'add_plugin_action_link'), 10, 1);
        }

        public function init() {

            // Check if Elementor installed and activated
            if (!did_action('elementor/loaded')) {
                add_action('admin_notices', array($this, 'required_plugins_notice'));
                return;
            }

            require EEAD_PATH . 'inc/helper-functions.php';
            require EEAD_PATH . 'inc/widget-loader.php';
            require EEAD_PATH . 'inc/icon-manager.php';
            require EEAD_PATH . 'inc/sticky-container.php';
            require EEAD_PATH . 'inc/admin-menu/admin-menu-class.php';
            //require EEAD_PATH . 'templates/templates.php';
        }

        public function required_plugins_notice() {
            $screen = get_current_screen();
            if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
                return;
            }

            $plugin = 'elementor/elementor.php';

            if ($this->is_elementor_installed()) {
                if (!current_user_can('activate_plugins')) {
                    return;
                }

                $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
                $admin_message = '<p>' . esc_html__('Oops! Easy Elementor Addons is not working because you need to activate the Elementor plugin first.', 'easy-elementor-addons') . '</p>';
                $admin_message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__('Activate Elementor Now', 'easy-elementor-addons')) . '</p>';
            } else {
                if (!current_user_can('install_plugins')) {
                    return;
                }

                $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
                $admin_message = '<p>' . esc_html__('Oops! Easy Elementor Addons is not working because you need to install the Elementor plugin', 'easy-elementor-addons') . '</p>';
                $admin_message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__('Install Elementor Now', 'easy-elementor-addons')) . '</p>';
            }

            echo '<div class="error">' . wp_kses_post($admin_message) . '</div>';
        }

        /**
         * Check if theme has elementor installed
         *
         * @return boolean
         */
        public function is_elementor_installed() {
            $file_path = 'elementor/elementor.php';
            $installed_plugins = get_plugins();

            return isset($installed_plugins[$file_path]);
        }

        public function plugin_activation() {
        }

        public function add_plugin_action_link($links) {
            $custom['settings'] = sprintf(
                '<a href="%s" aria-label="%s">%s</a>', esc_url(add_query_arg('page', 'eead-settings', admin_url('admin.php'))), esc_attr__('Easy Elementor Addons Settings', 'easy-elementor-addons'), esc_html__('Settings', 'easy-elementor-addons')
            );

            return array_merge($custom, (array) $links);
        }
    }

}

/**
 * Returns instanse of the plugin class.
 *
 * @since  1.0.0
 * @return object
 */
if (!function_exists('easy_elementor_addons')) {

    function easy_elementor_addons() {
        return Easy_Elementor_Addons::get_instance();
    }

}

easy_elementor_addons();