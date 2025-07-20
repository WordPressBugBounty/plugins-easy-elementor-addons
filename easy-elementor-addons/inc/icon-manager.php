<?php

namespace EasyElementorAddons;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class EEAD_Icon_Manager {

    private static $instance = NULL;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct() {
        $this->init();
    }

    public function init() {
        // Custom icon filter
        add_filter('elementor/icons_manager/additional_tabs', [$this, 'icons']);
    }

    public function icons($icons_args = array()) {
        $icons_args = array(
            'eead-mdi-icon' => array(
                'name' => 'eead-mdi-icon',
                'label' => esc_html__('EEA - MaterialDesign Icons', 'easy-elementor-addons'),
                'labelIcon' => 'mdi-rhombus',
                'prefix' => 'mdi-',
                'displayPrefix' => 'mdi',
                'url' => EEAD_URL . 'assets/fonts/materialdesignicons/materialdesignicons.css',
                'icons' => eead_materialdesignicons_array(),
                'ver' => EEAD_VERSION,
            ),
            'eead-icofont-icon' => array(
                'name' => 'eead-icfont-icon',
                'label' => esc_html__('EEA - Iconfont Icons', 'easy-elementor-addons'),
                'labelIcon' => 'mdi-rhombus',
                'prefix' => 'icofont-',
                'displayPrefix' => '',
                'url' => EEAD_URL . 'assets/fonts/icofont/icofont.css',
                'icons' => eead_icofont_icon_array(),
                'ver' => EEAD_VERSION,
            ),
        );

        return $icons_args;
    }

}

EEAD_Icon_Manager::instance();