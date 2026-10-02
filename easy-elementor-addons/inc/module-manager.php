<?php

namespace EasyElementorAddons;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

final class EEAD_Modules_Manager {

    public function __construct() {
        $this->require_files();

        // Deferred to `init` so widget labels contributed by add-ons are built
        // after textdomains load. Elementor only instantiates widget types on
        // first use, which is always later than this.
        add_action('init', [$this, 'register_modules'], 20);
    }

    private function require_files() {
        require(EEAD_PATH . 'base/module-base.php');
    }

    public function register_modules() {
        foreach (\eead_get_enabled_widgets() as $module) {
            $class_name = str_replace('-', ' ', $module);
            $class_name = str_replace(' ', '', ucwords($class_name));
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

            // Add-ons contribute their own modules through `eead_all_widgets_list`,
            // so the class may live in a plugin whose files are no longer readable.
            if (!class_exists($class_name)) {
                continue;
            }

            $class_name::instance();
        }
    }

}

if (!function_exists('easy_elementor_addons_module_manager')) {

    function easy_elementor_addons_module_manager() {
        return new EEAD_Modules_Manager();
    }

}
easy_elementor_addons_module_manager();