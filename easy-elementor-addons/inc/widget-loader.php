<?php

namespace EasyElementorAddons;

if (!defined('ABSPATH'))
    exit();

class EEAD_Widget_Loader {

    private static $instance = NULL;

    public static function get_instance() {
        if (self::$instance == NULL) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function __construct() {
        spl_autoload_register([$this, 'autoload']);

        $this->includes();
        // Elementor hooks
        $this->add_actions();
    }

    public function autoload($class) {
        if (0 !== strpos($class, __NAMESPACE__)) {
            return;
        }

        if (!class_exists($class)) {
            $filename = strtolower(preg_replace(['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'], ['', '$1-$2', '-', DIRECTORY_SEPARATOR], $class));
            $filenamewithpath = EEAD_PATH . $filename . '.php';

            if (is_readable($filenamewithpath)) {
                include($filenamewithpath);
            } else if (defined('EEAD_PLUS_PATH')) {
                $filenamewithpath = EEAD_PLUS_PATH . 'admin/' . $filename . '.php';
                if (is_readable($filenamewithpath)) {
                    include($filenamewithpath);
                }
            }
        }
    }

    private function includes() {
        require EEAD_PATH . 'inc/module-manager.php';
    }

    public function add_actions() {
        add_action('elementor/init', [$this, 'add_elementor_widget_categories']);

        //FrontEnd Scripts
        add_action('elementor/frontend/before_register_scripts', [$this, 'register_frontend_scripts']);
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);

        //FrontEnd Styles
        add_action('elementor/frontend/before_register_styles', [$this, 'register_frontend_styles']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);

        //Editor Style
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);
    }

    function add_elementor_widget_categories() {
        $groups = array(
            'easy-elementor-addons' => esc_html__('Easy Elementor Addons', 'easy-elementor-addons'),
        );

        foreach ($groups as $key => $value) {
            \Elementor\Plugin::instance()->elements_manager->add_category($key, ['title' => $value], 1);
        }
    }

    /**
     * Register Frontend Scripts
     */
    public function register_frontend_scripts() {
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $eead_general_settings = get_option('eead_general_settings', []);
        $gmap_access_token = isset($eead_general_settings['gmap_access_token']) ? $eead_general_settings['gmap_access_token'] : '';

        // The Maps JavaScript API requires a key; without one the map shows an error.
        wp_register_script('gmap-api', add_query_arg(['key' => rawurlencode($gmap_access_token), 'libraries' => 'marker'], 'https://maps.googleapis.com/maps/api/js'), [], EEAD_VERSION, true);
        wp_register_script('plyr', EEAD_URL . 'assets/lib/plyr/plyr.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('countdown', EEAD_URL . 'assets/lib/countdown/countdown.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('image-compare', EEAD_URL . 'assets/lib/image-compare/image-compare-viewer.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('micromodal', EEAD_URL . 'assets/lib/micromodal/micromodal.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('morphext', EEAD_URL . 'assets/lib/morphext/morphext' . $suffix . '.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('typed', EEAD_URL . 'assets/lib/typed/typed' . $suffix . '.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('jclock', EEAD_URL . 'assets/lib/jclock/jquery.jclock' . $suffix . '.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('waypoint', EEAD_URL . 'assets/lib/waypoint/waypoint.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('odometer', EEAD_URL . 'assets/lib/odometer/odometer.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('light-gallery', EEAD_URL . 'assets/lib/lightgallery/lightgallery.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('isotope', EEAD_URL . 'assets/lib/isotope/isotope.pkgd.min.js', ['jquery', 'imagesloaded'], EEAD_VERSION, true);
        wp_register_script('uikit', EEAD_URL . 'assets/lib/uikit/uikit.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('owlcarousel', EEAD_URL . 'assets/lib/owl-carousel/js/owl.carousel.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('slick', EEAD_URL . 'assets/lib/slick/slick.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('mcustomscrollbar', EEAD_URL . 'assets/lib/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('chart', EEAD_URL . 'assets/lib/chart/chart.js', ['jquery'], EEAD_VERSION, true);
        wp_register_script('lottie', EEAD_URL . 'assets/lib/lottie/lottie.min.js', NULL, EEAD_VERSION, true);
        wp_register_script('twitter-widgets', 'https://platform.twitter.com/widgets.js', [], EEAD_VERSION, true);
    }

    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script('eead-frontend-script', EEAD_URL . 'assets/js/frontend.js', ['jquery', 'elementor-frontend'], EEAD_VERSION, true);
    }

    /**
     * Register Frontend Styles
     */
    public function register_frontend_styles() {
        wp_register_style('plyr', EEAD_URL . 'assets/lib/plyr/plyr.min.css', array(), EEAD_VERSION);
        wp_register_style('image-compare', EEAD_URL . 'assets/lib/image-compare/image-compare.css', array(), EEAD_VERSION);
        wp_register_style('micromodal', EEAD_URL . 'assets/lib/micromodal/micromodal.min.css', array(), EEAD_VERSION);
        wp_register_style('odometer-theme-default', EEAD_URL . 'assets/lib/odometer/odometer-theme-default.css', array(), EEAD_VERSION);
        wp_register_style('light-gallery', EEAD_URL . 'assets/lib/lightgallery/lightgallery.css', array(), EEAD_VERSION);
        wp_register_style('owlcarousel', EEAD_URL . 'assets/lib/owl-carousel/css/owl.carousel.min.css', array(), EEAD_VERSION);
        wp_register_style('slick', EEAD_URL . 'assets/lib/slick/slick.css', array(), EEAD_VERSION);
        wp_register_style('mcustomscrollbar', EEAD_URL . 'assets/lib/mcustomscrollbar/jquery.mCustomScrollbar.min.css', array(), EEAD_VERSION);
        wp_register_style('weather-icons', EEAD_URL . 'assets/fonts/weather-icons/weather-icons.css', array(), EEAD_VERSION);
        wp_register_style('uikit', EEAD_URL . 'assets/lib/uikit/uikit.css', array(), EEAD_VERSION);
    }

    /**
     * Enqueue Frontend Styles
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style('icofont', EEAD_URL . 'assets/fonts/icofont/icofont.css', array(), EEAD_VERSION);
        wp_enqueue_style('eead-custom-animate', EEAD_URL . 'assets/lib/animate/animate.css', array(), EEAD_VERSION);
        wp_enqueue_style('eead-frontend', EEAD_URL . 'assets/css/frontend.css', array(), EEAD_VERSION);
    }

    /**
     * Enqueue Editor Styles
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style('easy-elementor-addons-icon-style', EEAD_ASSETS_URL . 'fonts/eeaddons/eeaddons.css', array(), EEAD_VERSION);
    }

}

if (!function_exists('easy_elementor_addons_widget_loader')) {

    function easy_elementor_addons_widget_loader() {
        return EEAD_Widget_Loader::get_instance();
    }

}
easy_elementor_addons_widget_loader();
