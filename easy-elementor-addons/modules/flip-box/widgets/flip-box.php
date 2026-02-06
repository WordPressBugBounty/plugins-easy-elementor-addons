<?php

namespace EasyElementorAddons\Modules\FlipBox\Widgets;

// Elementor Classes
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class FlipBox extends Widget_Base {

    public function get_name() {
        return 'eead-flip-box';
    }

    public function get_title() {
        return esc_html__('Flip Box', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-flip-box';
    }

    public function get_keywords() {
        return ['3d', 'flip', 'box'];
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return [];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_front_side_content', [
                'label' => esc_html__('Front', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'graphic_element', [
                'label' => esc_html__('Icon Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-close',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ]
                ],
                'default' => 'icon'
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'label' => esc_html__('Image Size', 'easy-elementor-addons'),
                'default' => 'thumbnail',
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_control(
            'box_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_view', [
                'label' => esc_html__('Icon Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('None', 'easy-elementor-addons'),
                    'stacked' => esc_html__('Stacked', 'easy-elementor-addons'),
                    'framed' => esc_html__('Framed', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_shape', [
                'label' => esc_html__('Shape', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__('Circle', 'easy-elementor-addons'),
                    'square' => esc_html__('Square', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'icon_view!' => 'default',
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'front_title_text', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('This is the heading', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Your Title', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'front_description_text', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit magna aliqua. Ut enim ad minim veniam, laboris nisi ut aliquip ex ea commodo consequat.',
                'placeholder' => esc_html__('Your Description', 'easy-elementor-addons'),
                'title' => esc_html__('Input image text here', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'front_title_tags', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => eead_html_tags()
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_back_content', [
                'label' => esc_html__('Back', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'back_title_text', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('This is the heading', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Your Title', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'back_description_text', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit magna aliqua. Ut enim ad minim veniam, laboris nisi ut aliquip ex ea commodo consequat.',
                'placeholder' => esc_html__('Your Description', 'easy-elementor-addons'),
                'title' => esc_html__('Input image text here', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Continue', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'http://your-link.com',
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ]
            ]
        );

        $this->add_control(
            'link_click', [
                'label' => esc_html__('Apply Link On', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'box' => esc_html__('Whole Box', 'easy-elementor-addons'),
                    'button' => esc_html__('Button Only', 'easy-elementor-addons'),
                ],
                'default' => 'button',
                'condition' => [
                    'link[url]!' => '',
                ]
            ]
        );

        $this->add_control(
            'back_title_tags', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => eead_html_tags()
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ]
                ],
                'size_units' => ['px', 'em', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .eead-fb-layer, {{WRAPPER}} .eead-flip-box .eead-fb-layer-overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'flip_effect', [
                'label' => esc_html__('Flip Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'flip',
                'options' => [
                    'flip' => esc_html__('Flip', 'easy-elementor-addons'),
                    'slide' => esc_html__('Slide', 'easy-elementor-addons'),
                    'push' => esc_html__('Push', 'easy-elementor-addons'),
                    'zoom-in' => esc_html__('Zoom In', 'easy-elementor-addons'),
                    'zoom-out' => esc_html__('Zoom Out', 'easy-elementor-addons'),
                    'fade' => esc_html__('Fade', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-fb-effect-'
            ]
        );

        $this->add_control(
            'flip_direction', [
                'label' => esc_html__('Flip Direction', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons'),
                    'up' => esc_html__('Up', 'easy-elementor-addons'),
                    'down' => esc_html__('Down', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'flip_effect!' => [
                        'fade',
                        'zoom-in',
                        'zoom-out',
                    ]
                ],
                'prefix_class' => 'eead-fb-direction-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_front', [
                'label' => esc_html__('Front', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'front_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-flip-box .eead-fb-front'
            ]
        );

        $this->add_control(
            'front_background_overlay', [
                'label' => esc_html__('Background Overlay', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .eead-fb-front .eead-fb-layer-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'front_background_image[id]!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'front_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .eead-fb-front .eead-fb-layer-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'front_alignment', [
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .eead-fb-front .eead-fb-layer-overlay' => 'text-align: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'front_vertical_position', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .eead-fb-front .eead-fb-layer-overlay' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'front_border',
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
                'selector' => '{{WRAPPER}} .eead-fb-front',
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('front_style_tabs');

        $this->start_controls_tab(
            'front_icon_style_tab', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_primary_color', [
                'label' => esc_html__('Primary Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .eead-flip-box .elementor-view-framed .elementor-icon, {{WRAPPER}} .eead-flip-box .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} .eead-flip-box .elementor-view-framed .elementor-icon svg, .elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_secondary_color', [
                'label' => esc_html__('Secondary Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view' => 'stacked',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding', [
                'label' => esc_html__('Icon Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ]
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view!' => 'default',
                ]
            ]
        );

        $this->add_control(
            'icon_rotate', [
                'label' => esc_html__('Icon Rotate', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max' => 360,
                        'min' => -360,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon i' => 'transform: rotate({{SIZE}}deg);',
                    '{{WRAPPER}} .eead-flip-box .elementor-icon svg' => 'transform: rotate({{SIZE}}deg);',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view' => 'framed',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view!' => 'default',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-flip-box .elementor-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'front_image_style_tab', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_width', [
                'label' => esc_html__('Size (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => '%',
                    'size' => 10
                ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-image img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_control(
            'image_opacity', [
                'label' => esc_html__('Opacity (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-image' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'front_title_style_tab', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'condition' => [
                    'front_title_text!' => '',
                ]
            ]
        );

        $this->add_control(
            'front_title_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-front .eead-fb-layer-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'front_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-fb-front .eead-fb-layer-title'
            ]
        );

        $this->add_responsive_control(
            'front_title_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-front .eead-fb-layer-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'front_description_text!' => '',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'front_description_style_tab', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'condition' => [
                    'front_description_text!' => '',
                ]
            ]
        );

        $this->add_control(
            'front_description_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-front .eead-fb-layer-desc' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'front_description_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-fb-front .eead-fb-layer-desc'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_back', [
                'label' => esc_html__('Back', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'back_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-fb-back'
            ]
        );

        $this->add_control(
            'back_background_overlay', [
                'label' => esc_html__('Background Overlay', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'back_background_image[id]!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'back_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'back_border',
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
                'selector' => '{{WRAPPER}} .eead-fb-back',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'back_alignment', [
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-overlay' => 'text-align: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'back_vertical_position', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-overlay' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->start_controls_tabs('back_style_tabs');

        $this->start_controls_tab(
            'back_title_style_tab', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'condition' => [
                    'back_title_text!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'back_title_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'back_title_text!' => '',
                ]
            ]
        );

        $this->add_control(
            'back_title_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'back_title_text!' => '',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'back_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-fb-back .eead-fb-layer-title',
                'condition' => [
                    'back_title_text!' => '',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_description_style_tab', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'condition' => [
                    'back_description_text!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'back_description_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_text!' => '',
                ]
            ]
        );

        $this->add_control(
            'back_description_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-back .eead-fb-layer-desc' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'back_description_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-fb-back .eead-fb-layer-desc'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_text!' => '',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .eead-fb-button'
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
                'selector' => '{{WRAPPER}} .eead-fb-button'
            ]
        );

        $this->add_responsive_control(
            'button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_text_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-fb-button'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_hover_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_hover_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_hover_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-fb-button:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .eead-fb-button:hover'
            ]
        );

        $this->add_control(
            'button_hover_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('button', [
            'class' => [
                'eead-fb-button',
                $settings['button_hover_animation'] ? ' elementor-animation-' . esc_attr($settings['button_hover_animation']) : ''
            ],
            'href' => esc_url($settings['link']['url']),
            'target' => $settings['link']['is_external'] ? '_blank' : '_self'
        ]);


        $this->add_render_attribute('box_link', [
            'class' => 'eead-fb-link',
            'href' => esc_url($settings['link']['url'])
        ]);
        if ($settings['link']['is_external']) {
            $this->add_render_attribute('box_link', 'target', '_blank');
        }

        if ($settings['graphic_element'] === 'icon') {
            $this->add_render_attribute('icon-wrapper', [
                'class' => ['elementor-icon-wrapper', ' elementor-view-' . esc_attr($settings['icon_view'])]
            ]);
            if ('default' != $settings['icon_view']) {
                $this->add_render_attribute('icon-wrapper', 'class', 'elementor-shape-' . esc_attr($settings['icon_shape']));
            }
        }

        $this->add_render_attribute('box_front_title_tags', 'class', 'eead-fb-layer-title');
        ?>
        <div class="eead-flip-box">
            <div class="eead-fb-layer eead-fb-front">
                <div class="eead-fb-layer-overlay">
                    <div class="eead-fb-layer-inner">
                        <?php if ($settings['graphic_element'] === 'image' && !empty($settings['image']['url'])) { ?>
                            <div class="eead-fb-image">
                                <?php echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image')); ?>
                            </div>
                        <?php } elseif ($settings['graphic_element'] === 'icon' && !empty($settings['box_icon']['value'])) { ?>
                            <div <?php $this->print_render_attribute_string('icon-wrapper'); ?>>
                                <div class="elementor-icon">
                                    <?php
                                    Icons_Manager::render_icon($settings['box_icon'], ['aria-hidden' => 'true']);
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($settings['front_title_text'])) { ?>
                            <<?php echo esc_attr(eead_check_allowed_html_tags($settings['front_title_tags'])); ?>             <?php $this->print_render_attribute_string('box_front_title_tags'); ?>>
                                <?php echo wp_kses($settings['front_title_text'], eead_allow_tags('title')); ?>
                            </<?php echo esc_attr(eead_check_allowed_html_tags($settings['front_title_tags'])); ?>>
                        <?php } ?>

                        <?php if (!empty($settings['front_description_text'])) { ?>
                            <div class="eead-fb-layer-desc">
                                <?php echo wp_kses($settings['front_description_text'], eead_allow_tags('text')); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="eead-fb-layer eead-fb-back">
                <div class="eead-fb-layer-overlay">
                    <div class="eead-fb-layer-inner">
                        <?php if (!empty($settings['back_title_text'])) { ?>
                            <<?php echo esc_attr(eead_check_allowed_html_tags($settings['back_title_tags'])); ?>             <?php $this->print_render_attribute_string('box_front_title_tags'); ?>>
                                <?php echo wp_kses($settings['back_title_text'], eead_allow_tags('title')); ?>
                            </<?php echo esc_attr(eead_check_allowed_html_tags($settings['back_title_tags'])); ?>>
                        <?php } ?>

                        <?php if (!empty($settings['back_description_text'])) { ?>
                            <div class="eead-fb-layer-desc">
                                <?php echo wp_kses($settings['back_description_text'], eead_allow_tags('text')); ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($settings['button_text'])) { ?>
                            <a <?php $this->print_render_attribute_string('button'); ?>>
                                <?php echo wp_kses($settings['button_text'], eead_allow_tags('title')); ?>
                            </a>
                        <?php } ?>
                    </div>
                    <?php
                    if ($settings['link_click'] === 'box') {
                        ?>
                        <a <?php $this->print_render_attribute_string('box_link'); ?>></a>;
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

}
