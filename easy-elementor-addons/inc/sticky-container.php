<?php

namespace EasyElementorAddons;


// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class Sticky_Container {

    private static $instance = null;

    public static function instance(): Sticky_Container {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct() {
        $this->init();
    }

    public function init() {
        add_action('elementor/element/container/section_effects/before_section_end', [$this, 'add_controls']);
    }

    public function add_controls($section) {
        $section->add_control(
            'eead_sticky_container', [
                'label' => esc_html__('Enable Sticky', 'easy-elementor-addons'),
                'description' => esc_html__('Container must be nested inside another container.', 'easy-elementor-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'prefix_class' => 'eead-sticky-container-',
                'return_value' => 'yes',
            ]
        );

        $section->add_control(
            'eead_sticky_container_top_spacing', array(
                'label' => esc_html__('Top Spacing(px)', 'easy-elementor-addons'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 50,
                'min' => 0,
                'max' => 500,
                'step' => 1,
                'condition' => array(
                    'eead_sticky_container' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}}' => '--eead-sticky-top-spacing: {{VALUE}}px',
                ),
            )
        );
    }

}

Sticky_Container::instance();
