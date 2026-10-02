<?php
/**
 * *Admin Menu Class 
 * */

namespace EasyElementorAddons;

if (!defined('ABSPATH')) {
    exit;
}

class AdminClass {

    public function __construct() {
        add_action('wp_ajax_eead_admin_settings_save', [$this, 'eead_settings_save']);
        add_action('wp_ajax_eead_widgets_save', [$this, 'eead_widgets_save']);

        add_action('admin_menu', [$this, 'eead_register_admin_menu'], 20);
        add_action('admin_enqueue_scripts', [$this, 'eead_admin_enqueue_scripts']);
    }

    public function eead_admin_enqueue_scripts($hook) {
        if ('toplevel_page_eead-settings' !== $hook) {
            return;
        }

        wp_enqueue_style('eead-admin-menu', EEAD_URL . 'assets/css/eead-admin-menu.css', false, EEAD_VERSION);
        wp_enqueue_style('materialdesignicons', EEAD_URL . 'assets/fonts/materialdesignicons/materialdesignicons.css', false, EEAD_VERSION);
        wp_enqueue_style('eeaddons-icon', EEAD_ASSETS_URL . 'fonts/eeaddons/eeaddons.css', array(), EEAD_VERSION);

        wp_enqueue_script('eead-admin', EEAD_URL . 'assets/js/admin.js', ['jquery'], EEAD_VERSION, true);
        wp_localize_script('eead-admin', 'admin_ajax_script', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('eead_ajax_nonce'),
        ]);
    }

    public function eead_register_admin_menu() {
        add_menu_page(esc_html__('Easy Elementor Addons', 'easy-elementor-addons'), esc_html__('Easy Elementor Addons', 'easy-elementor-addons'), 'manage_options', 'eead-settings', [$this, 'eead_settings_page_display'], 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNjAuNjQgMTYwLjY3IiBmaWxsPSIjRkZGIj4KICA8cGF0aCBkPSJNNzQuNTUgMTQuOTRBMTQuOTMgMTQuOTMgMCAwIDAgNTkuNjQgMEgxNC45MUExNC45MyAxNC45MyAwIDAgMCAwIDE0Ljk0djQ0LjczYTE0LjkzIDE0LjkzIDAgMCAwIDE0LjkxIDE0LjkxaDQ0LjczYTE0LjkzIDE0LjkzIDAgMCAwIDE0LjkxLTE0LjkxWm0wIDg2LjA5YTE0LjkyIDE0LjkyIDAgMCAwLTE0LjkxLTE0LjkxSDE0LjkxQTE0LjkyIDE0LjkyIDAgMCAwIDAgMTAxdjQ0LjczYTE0LjkzIDE0LjkzIDAgMCAwIDE0LjkxIDE0LjkxaDQ0LjczYTE0LjkzIDE0LjkzIDAgMCAwIDE0LjkxLTE0LjkxWm04Ni4wOSAwYTE0LjkyIDE0LjkyIDAgMCAwLTE0LjkxLTE0LjkxSDEwMUExNC45IDE0LjkgMCAwIDAgODYuMDkgMTAxdjQ0LjczQTE0LjkyIDE0LjkyIDAgMCAwIDEwMSAxNjAuNjdoNDQuNzNhMTQuOTMgMTQuOTMgMCAwIDAgMTQuOTEtMTQuOTFaTTEzMy44IDQuMzNhMTQuODEgMTQuODEgMCAwIDAtMjAuOTIgMGwtMjIuNSAyMi41YTE0Ljc5IDE0Ljc5IDAgMCAwIDAgMjAuOTFsMjIuNSAyMi41YTE0Ljc5IDE0Ljc5IDAgMCAwIDIwLjkyIDBsMjIuNDktMjIuNWExNC43NyAxNC43NyAwIDAgMCAwLTIwLjl6Ii8+Cjwvc3ZnPgo=', 99);
    }

    public function eead_settings_save() {
        if (!current_user_can('manage_options')) {
            wp_die('', '', 403);
        }

        if (wp_verify_nonce(eead_get_post('wp_nonce'), 'eead_ajax_nonce')) {
            $data_ar = eead_get_post('data');
            $settings_ar = [];
            $allowed_keys = apply_filters('eead_general_settings_keys', ['gmap_access_token', 'gmap_map_id', 'weather_api_key']);

            foreach ((array) $data_ar as $value) {
                if (isset($value['name'], $value['value']) && in_array($value['name'], $allowed_keys, true)) {
                    $settings_ar[$value['name']] = $value['value'];
                }
            }

            $update = update_option('eead_general_settings', $settings_ar);
            echo $update ? 'yes' : 'no';
        }
        die();
    }

    public function eead_widgets_save() {
        if (!current_user_can('manage_options')) {
            wp_die('', '', 403);
        }

        if (wp_verify_nonce(eead_get_post('wp_nonce'), 'eead_ajax_nonce')) {
            /*
             * jQuery omits an empty array from the request body altogether, so
             * clearing every checkbox arrives with no `data` key at all. Stored
             * as it came in, that became an empty string, which the reader treats
             * as "never saved" and answers with the full widget list - turning
             * "disable everything" into "enable everything".
             */
            $data_ar = eead_get_post('data');
            $data_ar = is_array($data_ar) ? array_values($data_ar) : array();

            update_option('eead_widgets', array());
            $update_widgets = update_option('eead_widgets', $data_ar);
            echo ($update_widgets || empty($data_ar)) ? 'yes' : 'no';
        }
        die();
    }

    public function get_widget_field($label, $val, $icon = '', $url = '', $premium = false, $category = '') {
        // Same source of truth the module manager registers from, so a fresh
        // install shows every widget ticked instead of an all-off dashboard.
        static $eead_widgets = null;

        if (null === $eead_widgets) {
            $eead_widgets = \eead_get_enabled_widgets();
        }

        ?>

        <div class="eead-widget-wrap <?php echo $premium ? 'eead-premium' : ''; ?>" data-main="<?php echo $premium ? 'pro' : 'free'; ?>" data-sub="<?php echo esc_attr($category); ?>">
            <span>
                <?php
                if ($icon) {
                    echo '<i class="' . esc_attr($icon) . '"></i>';
                }
                echo esc_html($label);
                ?>
            </span>
            <div class="eead-checkbox">
                <input type="checkbox" class="eead-widget-checkbox" name="widgets" value="<?php echo esc_attr($val); ?>" <?php checked(in_array($val, $eead_widgets), true); ?>>
                <label></label>
            </div>

            <?php
            if ($premium) {
                ?>
                <span class="eead-widget-pro-badge"><?php echo esc_html__('Pro', 'easy-elementor-addons'); ?></span>
                <?php
            }

            // Add-on widgets may ship without a demo page; an empty href would just
            // reload this screen, so the link is dropped instead.
            if ($url) {
                ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="eead-widget-demo-link"><?php echo esc_html__('View Demo', 'easy-elementor-addons'); ?></a>
                <?php
            }
            ?>
        </div>

        <?php
    }

    public function eead_settings_page_display() {
        include EEAD_PATH . 'inc/admin-menu/admin-menu-page.php';
    }

}

new AdminClass();
