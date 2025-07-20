<?php

namespace EasyElementorAddons\Modules\Slider\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Slider Widget
 */
class Slider extends Widget_Base {

    public function get_name() {
        return 'eead-slider';
    }

    public function get_title() {
        return esc_html__('Slider', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-slider';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['slick'];
    }

    public function get_script_depends() {
        return ['slick'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slider_image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_control(
            'slider_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'slider_sub_title', [
                'label' => esc_html__('Sub Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 8,
                'placeholder' => esc_html__('Type your description here', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'slider_button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Details', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'slider_button_link', [
                'label' => esc_html__('Button Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('Enter URL', 'easy-elementor-addons'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ]
            ]
        );

        $this->add_control(
            'slider_block', [
                'label' => esc_html__('Sliders', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slider_title' => esc_html__('Slider #1', 'easy-elementor-addons'),
                        'slider_sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'slider_button_link' => '#'
                    ],
                    [
                        'slider_title' => esc_html__('Slider #2', 'easy-elementor-addons'),
                        'slider_sub_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'slider_button_link' => '#'
                    ]
                ],
                'title_field' => '{{{ slider_title }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'normal_slider_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail',
                'label' => esc_html__('Image Size', 'easy-elementor-addons'),
                'default' => 'full'
            ]
        );

        $this->add_control(
            'slider_height_type', [
                'label' => esc_html__('Slider Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto' => esc_html__('Auto', 'easy-elementor-addons'),
                    'full' => esc_html__('Screen Height', 'easy-elementor-addons'),
                    'custom' => esc_html__('Custom Height', 'easy-elementor-addons'),
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_slider_height', [
                'label' => esc_html__('Custom Slider Height (px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 2000,
                        'step' => 1
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 800,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 600,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 400,
                    'unit' => 'px',
                ],
                'condition' => ['slider_height_type' => 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'slider_setting_heading',
            [
                'label' => esc_html__('Slider Settings', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slider_transition', [
                'label' => esc_html__('Slider Transition', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__('Slide', 'easy-elementor-addons'),
                    'fade' => esc_html__('Fade', 'easy-elementor-addons')
                ]
            ]
        );

        $this->add_control(
            'autoplay', [
                'label' => esc_html__('Autoplay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'pause_on_hover', [
                'label' => esc_html__('Pause on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => [
                    'autoplay' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'infinite', [
                'label' => esc_html__('Infinite Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'autoplay_speed', [
                'label' => esc_html__('Autoplay Speed (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 1,
                        'max' => 15,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 5,
                    'unit' => 's',
                ],
                'condition' => [
                    'autoplay' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'speed', [
                'label' => esc_html__('Animation Speed (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500
            ]
        );

        $this->add_control(
            'dots', [
                'label' => esc_html__('Navigation Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'arrows', [
                'label' => esc_html__('Navigation Arrows', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'auto_height', [
                'label' => esc_html__('Adaptive Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'slider_height_type' => 'auto'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'caption_animation', [
                'label' => esc_html__('Caption Animation', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => eead_slider_animations(),
            ]
        );

        $this->add_control(
            'title_animation_duration', [
                'label' => esc_html__('Animation Duration (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0.5,
                    'unit' => 's',
                ],
                'condition' => [
                    'title_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-title-animation-duration: {{SIZE}}s;',
                ]
            ]
        );

        $this->add_control(
            'title_animation_delay', [
                'label' => esc_html__('Animation Delay (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 's',
                ],
                'condition' => [
                    'title_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-title-animation-delay: {{SIZE}}s;',
                ]
            ]
        );

        $this->add_control(
            'sub_title_heading',
            [
                'label' => esc_html__('Sub Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title_animation', [
                'label' => esc_html__('Sub Title Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => eead_slider_animations(),
            ]
        );

        $this->add_control(
            'sub_title_animation_duration', [
                'label' => esc_html__('Animation Duration (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0.5,
                    'unit' => 's',
                ],
                'condition' => [
                    'sub_title_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-sub-title-animation-duration: {{SIZE}}s;',
                ]
            ]
        );

        $this->add_control(
            'sub_title_animation_delay', [
                'label' => esc_html__('Animation Delay (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 's',
                ],
                'condition' => [
                    'sub_title_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-sub-title-animation-delay: {{SIZE}}s;',
                ]
            ]
        );

        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_animation', [
                'label' => esc_html__('Button Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => eead_slider_animations(),
            ]
        );

        $this->add_control(
            'button_animation_duration', [
                'label' => esc_html__('Animation Duration (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0.5,
                    'unit' => 's',
                ],
                'condition' => [
                    'button_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-button-animation-duration: {{SIZE}}s;',
                ]
            ]
        );

        $this->add_control(
            'button_animation_delay', [
                'label' => esc_html__('Animation Delay (in Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 's',
                ],
                'condition' => [
                    'button_animation!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider' => '--eead-slide-button-animation-delay: {{SIZE}}s;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_style', [
                'label' => esc_html__('Slider Overlay', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'slider-overlay-popover-toggle',
            [
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Slider Overlay', 'easy-elementor-addons'),
                'label_off' => esc_html__('Default', 'easy-elementor-addons'),
                'label_on' => esc_html__('Custom', 'easy-elementor-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'overlay_bg',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-slide:before',
                'condition' => [
                    'slider-overlay-popover-toggle' => 'yes'
                ]
            ]
        );

        $this->end_popover();

        $this->end_controls_section();

        $this->start_controls_section(
            'caption_style', [
                'label' => esc_html__('Caption Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'enable_container', [
                'label' => esc_html__('Enable Centered Container Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'container_width', [
                'label' => esc_html__('Container Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 500,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption-container' => 'width:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'enable_container' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_width', [
                'label' => esc_html__('Caption Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 500,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'width:{{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'caption_h_position', [
                'label' => esc_html__('Horizontal Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors_dictionary' => [
                    'center' => 'left:50%;text-align:center',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => '{{VALUE}};--eead-slider-caption-h:-50%;'
                ],
            ]
        );

        $this->add_responsive_control(
            'caption_offset_left', [
                'label' => esc_html__('Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'left:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'caption_h_position' => 'left',
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_offset_right', [
                'label' => esc_html__('Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'right:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'caption_h_position' => 'right',
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_v_position', [
                'label' => esc_html__('Vertical Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'default' => 'middle',
                'toggle' => false,
                'selectors_dictionary' => [
                    'middle' => 'top:50%;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => '{{VALUE}};--eead-slider-caption-v:-50%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'caption_offset_top', [
                'label' => esc_html__('Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'top:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'caption_v_position' => 'top',
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_offset_bottom', [
                'label' => esc_html__('Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'bottom:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'caption_v_position' => 'bottom',
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_alignment', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'caption_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-slide-caption',
                'exclude' => ['image']
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'caption_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'none',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#444444',
                    ]
                ],
                'selector' => '{{WRAPPER}} .eead-slide-caption'
            ]
        );

        $this->add_responsive_control(
            'caption_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-title span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-slide-cap-title'
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .eead-slide-cap-title'
            ]
        );

        $this->add_responsive_control(
            'title_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'title_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'title_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-title' => 'margin-bottom:{{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sub_title_style', [
                'label' => esc_html__('Sub Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'sub_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-desc' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'sub_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-slide-cap-desc'
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'sub_title_shadow',
                'selector' => '{{WRAPPER}} .eead-slide-cap-desc'
            ]
        );

        $this->add_responsive_control(
            'sub_title_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-cap-desc' => 'margin-bottom:{{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-slide-button a'
            ]
        );

        $this->start_controls_tabs(
            'button_style_tabs'
        );

        $this->start_controls_tab(
            'normal_button_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'none',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#444444',
                    ]
                ],
                'selector' => '{{WRAPPER}} .eead-slide-button a'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover_button_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_bg_hover_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_hover_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_hover_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a:hover' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slide-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'dot_style', [
                'label' => esc_html__('Navigation Dot', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_spacing', [
                'label' => esc_html__('Spacing Between Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors_dictionary' => [
                    'left' => 'left:0',
                    'right' => 'right:0',
                    'center' => 'left:50%;--eead-slider-dots-offset-x:-50%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots' => '{{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_translate_x', [
                'label' => esc_html__('Horizontal Offset (px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container' => '--eead-slider-dots-offset-x:{{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'dots_alignment!' => 'center'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_translate_y', [
                'label' => esc_html__('Vertical Offset (px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => -20,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container' => '--eead-slider-dots-offset-y:{{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'dots_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'none',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#444444',
                    ]
                ],
                'selector' => '{{WRAPPER}} .eead-slider-container .slick-dots button'
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'dot_tabs'
        );

        $this->start_controls_tab(
            'dot_style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'dot_style_active_tab', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color_active', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots .slick-active button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots .slick-active button' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_scale_active', [
                'label' => esc_html__('Scale Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '1.3'
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1.5,
                        'step' => .05
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots .slick-active button' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'dot_style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-dots button:hover' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* Arrow Style */
        $this->start_controls_section(
            'arrow_style', [
                'label' => esc_html__('Navigation Arrow', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_on_hover', [
                'label' => esc_html__('Show on Hover Only', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'arrow_position', [
                'label' => esc_html__('Arrow Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'middle-center',
                'options' => [
                    'bottom-left' => esc_html__('Bottom Left', 'easy-elementor-addons'),
                    'bottom-center' => esc_html__('Bottom Center', 'easy-elementor-addons'),
                    'bottom-right' => esc_html__('Bottom Right', 'easy-elementor-addons'),
                    'middle-center' => esc_html__('Middle Center', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'arrow_orientation', [
                'label' => esc_html__('Arrow Orientation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__('Horizontal', 'easy-elementor-addons'),
                    'column' => esc_html__('Vertical', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'arrow_position' => ['bottom-left', 'bottom-right']
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav' => 'flex-direction: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 60,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 60,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_translate_x', [
                'label' => esc_html__('Horizontal Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container' => '--eead-slider-nav-offset-x:{{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'arrow_position!' => 'bottom-center'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_translate_y', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container' => '--eead-slider-nav-offset-y:{{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_spacing', [
                'label' => esc_html__('Arrows Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav' => 'gap:{{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'arrow_position!' => 'middle-center'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'arrow_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'none',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#444444',
                    ]
                ],
                'selector' => '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow'
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'arrow_tabs'
        );

        $this->start_controls_tab(
            'arrow_style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'arrow_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'arrow_style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'arrow_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-slider-container .slick-nav .slick-arrow:hover' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'prev_icon_arrow', [
                'label' => esc_html__('Custom Prev Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'label_block' => false,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'next_icon_arrow', [
                'label' => esc_html__('Custom Next Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'label_block' => false
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $slider_transition = $settings['slider_transition'];
        $this->add_render_attribute('slider-container', [
            'class' => [
                'eead-slider-container',
                'eead-slider-nav-' . esc_attr($settings['arrow_position']),
                'eead-slider-height-' . esc_attr($settings['slider_height_type']),
                'eead-slider-show-nav-hover-' . ($settings['show_on_hover'] ? 'on' : 'off')
            ]
        ],
        );
        ?>

        <div <?php $this->print_render_attribute_string('slider-container'); ?>>
            <?php
            $sliders = $settings['slider_block'];
            $params = array(
                'autoplay' => $settings['autoplay'] && $settings['autoplay'] == 'yes' ? true : false,
                'loop' => $settings['infinite'] && $settings['infinite'] == 'yes' ? true : false,
                'pause' => isset($settings['autoplay_speed']['size']) && !empty($settings['autoplay_speed']['size']) ? (int) $settings['autoplay_speed']['size'] * 1000 : NULL,
                'speed' => (int) $settings['speed'],
                'dots' => $settings['dots'] == 'yes' ? true : false,
                'arrows' => $settings['arrows'] == 'yes' ? true : false,
                'pause_on_hover' => $settings['pause_on_hover'] == 'yes' ? true : false,
                'auto_height' => $settings['auto_height'] == 'yes' ? true : false,
                'prev_icon' => 'icofont-simple-left',
                'next_icon' => 'icofont-simple-right'
            );

            if (!empty($settings['prev_icon_arrow']['value'])) {
                $params['prev_icon'] = $settings['prev_icon_arrow']['value'];
            }

            if (!empty($settings['next_icon_arrow']['value'])) {
                $params['next_icon'] = $settings['next_icon_arrow']['value'];
            }

            $this->add_render_attribute('slider',
                [
                    'class' => [
                        'eead-slider',
                    ],
                    'data-params' => json_encode($params),
                    'data-transition' => $slider_transition,
                    'data-title-anim' => isset($settings['title_animation']) ? esc_attr($settings['title_animation']) : 'none',
                    'data-subtitle-anim' => isset($settings['sub_title_animation']) ? esc_attr($settings['sub_title_animation']) : 'none',
                    'data-button-anim' => isset($settings['button_animation']) ? esc_attr($settings['button_animation']) : 'none'
                ],
            );
            ?>

            <div <?php $this->print_render_attribute_string('slider'); ?>>
                <?php
                if (!empty($sliders)) {
                    foreach ($sliders as $key => $slider) {
                        $image = $slider['slider_image']['url'];
                        $title = $slider['slider_title'];
                        $caption = $slider['slider_sub_title'];
                        $button_text = $slider['slider_button_text'];
                        $button_link = $slider['slider_button_link']['url'];
                        ?>
                        <div class="eead-slide">
                            <?php
                            if ($image) {
                                $image_url = Group_Control_Image_Size::get_attachment_image_src($slider['slider_image']['id'], 'thumbnail', $settings);

                                if ($image_url) {
                                    echo '<img src="' . esc_url($image_url) . '">';
                                } else {
                                    echo '<img src="' . esc_url($slider['slider_image']['url']) . '">';
                                }
                            }
                            ?>
                            <?php if ($settings['enable_container']) { ?>
                                <div class="eead-slide-caption-container">
                                <?php } ?>
                                <div class="eead-slide-caption">
                                    <?php if ($title) { ?>
                                        <div class="eead-slide-cap-title">
                                            <span><?php echo wp_kses_post($title); ?></span>
                                        </div>
                                    <?php } ?>

                                    <?php if ($caption) { ?>
                                        <div class="eead-slide-cap-desc">
                                            <?php echo wp_kses_post($caption); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($button_link) { ?>
                                        <div class="eead-slide-button">
                                            <a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if ($settings['enable_container']) { ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
            <div class="slick-nav"></div>
            <div class="slick-dots-wrap"></div>
        </div>
        <?php
    }

}
