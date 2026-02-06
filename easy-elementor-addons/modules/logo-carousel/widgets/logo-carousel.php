<?php

namespace EasyElementorAddons\Modules\LogoCarousel\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class LogoCarousel extends Widget_Base {

    public function get_name() {
        return 'eead-logo-carousel';
    }

    public function get_title() {
        return esc_html__('Logo Carousel', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-logo-carousel';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['owlcarousel'];
    }

    public function get_script_depends() {
        return ['owlcarousel'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Title'
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_control(
            'logo_link', [
                'label' => esc_html__('Logo Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'slides', [
                'label' => esc_html__('Slides', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}'
            ]
        );

        $this->add_control(
            'link_new_tab', [
                'label' => esc_html__('Open Link in New Tab', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_title', [
                'label' => esc_html__('Show Logo Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'title_html_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => eead_html_tags(),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumb',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'full'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_settings', [
                'label' => esc_html__('Carousel Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'slides_to_show', [
                'label' => esc_html__('Slides To Show', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 2,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 1,
                    'unit' => 'px',
                ]
            ]
        );

        $this->add_responsive_control(
            'slides_margin', [
                'label' => esc_html__('Spacing Between Slides', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ]
            ]
        );

        $this->add_responsive_control(
            'slides_stagepadding', [
                'label' => esc_html__('Stage Padding', 'easy-elementor-addons'),
                'description' => esc_html__('Space or padding between the carousel stage and the edge of the container', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ]
            ]
        );

        $this->add_control(
            'infinite', [
                'label' => esc_html__('Infinite Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
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
                'default' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ]
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
            'auto_height', [
                'label' => esc_html__('Auto Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'dots', [
                'label' => esc_html__('Navigation Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
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
            'focus_center_logo', [
                'label' => esc_html__('Focus Center Logo', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'grayscale_side_logos', [
                'label' => esc_html__('Grayscale Side Logos', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-item:not(.center)' => 'filter: grayscale(100%);'
                ],
                'condition' => [
                    'focus_center_logo' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'shrink_side_logos', [
                'label' => esc_html__('Shrink Side Logos', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '0.8'
                ],
                'range' => [
                    'px' => [
                        'min' => 0.6,
                        'max' => 0.95,
                        'step' => .05
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-item:not(.center)' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
                ],
                'condition' => [
                    'focus_center_logo' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'logo_style', [
                'label' => esc_html__('Logo', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'logo_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .eead-logo-slide' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'logo_border',
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
                'selector' => '{{WRAPPER}} .eead-logo-carousel .eead-logo-slide'
            ]
        );

        $this->add_responsive_control(
            'logo_padding', [
                'label' => esc_html__('Logo Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .eead-logo-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius', [
                'label' => esc_html__('Logo Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .eead-logo-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logo_container_border_radius', [
                'label' => esc_html__('Logo Container Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .eead-logo-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots span' => 'width: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots span' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'dots_upper_spacing', [
                'label' => esc_html__('Spacing Above Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot span'
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}}',
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
                        'max' => 2,
                        'step' => .05
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot.active span' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}}',
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
                'label' => esc_html__('Show on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
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
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button' => 'width: {{SIZE}}{{UNIT}};'
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
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-logo-carousel' => '--eead-logo-carousel-offset-x:{{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-logo-carousel' => '--eead-logo-carousel-offset-y:{{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-logo-carousel .owl-nav button'
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel .owl-nav button:hover' => 'border-color: {{VALUE}}',
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
                'label_block' => false,
                'exclude_inline_options' => ['svg'],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'next_icon_arrow', [
                'label' => esc_html__('Custom Next Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'exclude_inline_options' => ['svg']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel.owl-carousel .eead-logo-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-logo-carousel.owl-carousel .eead-logo-title'
            ]
        );

        $this->add_responsive_control(
            'title_top_space', [
                'label' => esc_html__('Title Top Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-carousel.owl-carousel .eead-logo-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $target = $settings['link_new_tab'] ? '_blank' : '_self';
        $params = array(
            'items' => $settings['slides_to_show']['size'] ? (int) $settings['slides_to_show']['size'] : 3,
            'items_tablet' => isset($settings['slides_to_show_tablet']['size']) ? (int) $settings['slides_to_show_tablet']['size'] : 2,
            'items_mobile' => isset($settings['slides_to_show_mobile']['size']) ? (int) $settings['slides_to_show_mobile']['size'] : 1,
            'margin' => isset($settings['slides_margin']['size']) && $settings['slides_margin']['size'] !== null ? (int) $settings['slides_margin']['size'] : 20,
            'margin_tablet' => isset($settings['slides_margin_tablet']['size']) && $settings['slides_margin_tablet']['size'] !== null ? (int) $settings['slides_margin_tablet']['size'] : 20,
            'margin_mobile' => isset($settings['slides_margin_mobile']['size']) && $settings['slides_margin_mobile']['size'] !== null ? (int) $settings['slides_margin_mobile']['size'] : 20,
            'autoplay' => $settings['autoplay'] && $settings['autoplay'] == 'yes' ? true : false,
            'loop' => $settings['infinite'] && $settings['infinite'] == 'yes' ? true : false,
            'pause' => isset($settings['autoplay_speed']['size']) ? (int) $settings['autoplay_speed']['size'] * 1000 : 500,
            'dots' => $settings['dots'] == 'yes' ? true : false,
            'arrows' => $settings['arrows'] == 'yes' ? true : false,
            'pause_on_hover' => $settings['pause_on_hover'] == 'yes' ? true : false,
            'auto_height' => $settings['auto_height'] == 'yes' ? true : false,
            'stagepadding' => $settings['slides_stagepadding']['size'] && $settings['slides_stagepadding']['size'] !== null ? (int) $settings['slides_stagepadding']['size'] : 0,
            'stagepadding_tablet' => isset($settings['slides_stagepadding_tablet']['size']) && $settings['slides_stagepadding_tablet']['size'] !== null ? (int) $settings['slides_stagepadding_tablet']['size'] : 0,
            'stagepadding_mobile' => isset($settings['slides_stagepadding_mobile']['size']) && $settings['slides_stagepadding_mobile']['size'] !== null ? (int) $settings['slides_stagepadding_mobile']['size'] : 0,
            'focus_center_logo' => $settings['focus_center_logo'] == 'yes' ? true : false,
            'prev_icon' => 'icofont-simple-left',
            'next_icon' => 'icofont-simple-right'
        );

        if (!empty($settings['prev_icon_arrow']['value'])) {
            $params['prev_icon'] = $settings['prev_icon_arrow']['value'];
        }

        if (!empty($settings['next_icon_arrow']['value'])) {
            $params['next_icon'] = $settings['next_icon_arrow']['value'];
        }

        $params = json_encode($params);

        $this->add_render_attribute('logo_container', [
            'class' => [
                'eead-logo-carousel',
                'owl-carousel',
                'eead-lg-hover-arrow-' . ($settings['show_on_hover'] ? 'on' : 'off')
            ],
            'data-params' => $params
        ]);
        ?>
        <div <?php $this->print_render_attribute_string('logo_container'); ?>>
            <?php
            if ($settings['slides']) {
                foreach ($settings['slides'] as $item) {
                    $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'thumb', $settings);
                    if (!$image_url) {
                        $image_url = Utils::get_placeholder_image_src();
                    }
                    $image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(Control_Media::get_image_alt($item['image'])) . '" />';

                    echo '<div class="eead-logo-slide">';
                    if (!empty($item['logo_link'])) {
                        ?>
                        <a href="<?php echo esc_url($item['logo_link']); ?>" target="<?php echo esc_attr($target); ?>">
                            <?php echo wp_kses_post($image_html); ?>
                        </a>
                        <?php
                    } else {
                        echo wp_kses_post($image_html);
                    }
                    if ($settings['show_title']) {
                        echo '<' . esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])) . ' class="eead-logo-title">' . esc_html($item['title']) . '</' . esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])) . '>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
        <?php
    }

}
