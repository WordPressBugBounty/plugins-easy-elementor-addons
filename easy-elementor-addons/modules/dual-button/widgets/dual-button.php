<?php

namespace EasyElementorAddons\Modules\DualButton\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Dual Button Widget
 */
class DualButton extends Widget_Base {

    public function get_name() {
        return 'eead-dual-button';
    }

    public function get_title() {
        return esc_html__('Dual Button', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-dual-buttons';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'dual_btn_settings', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
            ]
        );

        $this->add_responsive_control(
            'button_layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'easy-elementor-addons'),
                    'vertical' => esc_html__('Vertical', 'easy-elementor-addons')
                ],
                'selectors_dictionary' => [
                    'horizontal' => '--eead-dual-button-direction:row;--eead-dual-button-align-items:center;--eead-dual-button-left-offset:100%;--eead-dual-button-top-offset:50%;--eead-dual-button-sep-margin-left:calc(var(--eead-dual-button-gap, 0)/2);--eead-dual-button-sep-margin-top:0;',
                    'vertical' => '--eead-dual-button-direction:column;--eead-dual-button-align-items:stretch;--eead-dual-button-left-offset:50%;--eead-dual-button-top-offset:100%;--eead-dual-button-justify-content:center;--eead-dual-button-sep-margin-left:0;--eead-dual-button-sep-margin-top:calc(var(--eead-dual-button-gap, 0)/2);',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons' => '{{VALUE}}'
                ],
                'default' => 'horizontal',
            ]
        );

        $this->add_responsive_control(
            'button_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons' => '--eead-dual-button-gap:{{SIZE}}px;'
                ],
            ]
        );

        $this->start_controls_tabs('tabs_dual_buttons_tabs');

        $this->start_controls_tab(
            'tab_primary_btn_tab', [
                'label' => esc_html__('Primary Button', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'pri_button_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => 'true',
                'default' => esc_html__('Primary Button', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Primary Button', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'pri_button_link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#'
                ],
            ]
        );

        $this->add_control(
            'pri_button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'pri_button_icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => esc_html__('Before', 'easy-elementor-addons'),
                    'row' => esc_html__('After', 'easy-elementor-addons')
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-pri-button .eead-dual-button' => 'flex-direction: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_secondary_btn_tab', [
                'label' => esc_html__('Secondary Button', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'sec_button_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => 'true',
                'dynamic' => [
                    'active' => true
                ],
                'default' => esc_html__('Secondary Button', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Secondary Button', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'sec_button_link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true
                ],
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#'
                ],
            ]
        );

        $this->add_control(
            'sec_button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'sec_button_icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => esc_html__('Before', 'easy-elementor-addons'),
                    'row' => esc_html__('After', 'easy-elementor-addons')
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-sec-button .eead-dual-button' => 'flex-direction: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-button' => 'gap: {{SIZE}}px;'
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_separator', [
                'label' => esc_html__('Separator', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'separator_type', [
                'label' => esc_html__('Separator Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'text' => esc_html__('Text', 'easy-elementor-addons'),
                    'icon' => esc_html__('Icon', 'easy-elementor-addons')
                ],
            ]
        );

        $this->add_control(
            'separator_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('OR', 'easy-elementor-addons'),
                'placeholder' => esc_html__('OR', 'easy-elementor-addons'),
                'condition' => [
                    'separator_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'separator_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['none'],
                'default' => [
                    'value' => 'icofont-plus',
                    'library' => 'iconfont'
                ],
                'label_block' => false,
                'condition' => [
                    'separator_type' => 'icon'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style', [
                'label' => esc_html__('General', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_animation', [
                'label' => esc_html__('Button Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'animation_1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'animation_2' => esc_html__('Style 1 - Alt', 'easy-elementor-addons'),
                    'animation_3' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'animation_4' => esc_html__('Style 2 - Alt', 'easy-elementor-addons'),
                    'animation_5' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'animation_6' => esc_html__('Style 3 - Alt', 'easy-elementor-addons'),
                    'animation_7' => esc_html__('Style 4', 'easy-elementor-addons'),
                    'animation_8' => esc_html__('Style 4 - Alt', 'easy-elementor-addons')
                ],
                'prefix_class' => 'animation-',
                'render_type' => 'template',
                'default' => 'none',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-container',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_primary_button', [
                'label' => esc_html__('Primary Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'pri_button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'pri_button_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'pri_button_text_hover_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:hover svg, {{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:focus svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'pri_button_background_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:not(.eead-animate):hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:not(.eead-animate):focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button' => '--eead-dual-button-hover-bg-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'pri_button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'pri_button_border_border!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button:focus' => 'border-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'pri_button_border',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button',
                'separator' => 'before',
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
            ]
        );

        $this->add_responsive_control(
            'pri_button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'pri_button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-pri-button .eead-dual-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_secondary_button', [
                'label' => esc_html__('Secondary Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_sec_button_style');

        $this->start_controls_tab(
            'tab_sec_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'sec_button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'sec_button_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_sec_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'sec_button_text_hover_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:hover svg, {{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:focus svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'sec_button_background_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:not(.eead-animate):hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:not(.eead-animate):focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button' => '--eead-dual-button-hover-bg-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'sec_button_border_hover_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'sec_button_border_border!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:hover, {{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button:focus' => 'border-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'sec_button_border',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button',
                'separator' => 'before',
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
            ]
        );

        $this->add_responsive_control(
            'sec_button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'sec_button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-sec-button .eead-dual-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_separator', [
                'label' => esc_html__('Separator', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'separator_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => '40'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'separator_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator',
                'condition' => [
                    'separator_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'separator_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => '14'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator svg' => 'height: {{SIZE}}{{UNIT}};width: auto;'
                ],
                'condition' => [
                    'separator_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'separator_icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator svg' => 'fill : {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'separator_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'separator_border',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator',
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
            ]
        );

        $this->add_responsive_control(
            'separator_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'separator_box_shadow',
                'selector' => '{{WRAPPER}} .eead-dual-buttons .eead-dual-button-separator',
                'fields_options' =>
                    [
                        'box_shadow_type' =>
                            [
                                'default' => 'yes'
                            ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 0,
                                    'blur' => 0,
                                    'spread' => 6,
                                    'color' => 'rgba(255, 255, 255, 0.2)'
                                ]
                        ]
                    ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('pri-button', 'class', 'eead-dual-button');
        if (!empty($settings['pri_button_link']['url'])) {
            $this->add_link_attributes('pri-button', $settings['pri_button_link']);
        }

        $this->add_render_attribute('sec-button', 'class', 'eead-dual-button');
        if (!empty($settings['sec_button_link']['url'])) {
            $this->add_link_attributes('sec-button', $settings['sec_button_link']);
        }

        $this->add_render_attribute('wrapper', [
            'class' => [
                'eead-dual-button-container'
            ]
        ]);

        if ($settings['button_animation'] !== 'none') {
            if ($settings['button_animation'] === 'animation_1') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-sweep-left');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-sweep-right');
            } elseif ($settings['button_animation'] === 'animation_2') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-sweep-right');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-sweep-left');
            } elseif ($settings['button_animation'] === 'animation_3') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-bounce-left');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-bounce-right');
            } elseif ($settings['button_animation'] === 'animation_4') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-bounce-right');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-bounce-left');
            } elseif ($settings['button_animation'] === 'animation_5') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-sweep-top');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-sweep-bottom');
            } elseif ($settings['button_animation'] === 'animation_6') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-sweep-bottom');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-sweep-top');
            } elseif ($settings['button_animation'] === 'animation_7') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-bounce-top');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-bounce-bottom');
            } elseif ($settings['button_animation'] === 'animation_8') {
                $this->add_render_attribute('pri-button', 'class', 'eead-animate eead-bounce-bottom');
                $this->add_render_attribute('sec-button', 'class', 'eead-animate eead-bounce-top');
            }
        }
        ?>
        <div class="eead-dual-buttons">
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div class="eead-dual-pri-button">
                    <a <?php $this->print_render_attribute_string('pri-button'); ?>>
                        <span>
                            <?php
                            echo esc_html($settings['pri_button_text']);
                            ?>
                        </span>
                        <?php
                        if ($settings['pri_button_icon']['value'] !== '') {
                            ?>
                            <?php
                            Icons_Manager::render_icon($settings['pri_button_icon'], ['aria-hidden' => 'true']);

                        }
                        ?>
                    </a>

                    <?php
                    if ((!empty($settings['separator_icon']['value']) || !empty($settings['separator_text']))) {
                        ?>
                        <span class="eead-dual-button-separator">
                            <?php
                            if ($settings['separator_type'] == 'text' && !empty($settings['separator_text'])) {
                                ?>
                                <span class="eead-dual-button-separator-text">
                                    <?php
                                    echo esc_html($settings['separator_text']);
                                    ?>
                                </span>
                                <?php
                            }

                            if ($settings['separator_type'] == 'icon' && !empty($settings['separator_icon']['value'])) {
                                ?>
                                <span class="eead-dual-button-separator-icon">
                                    <?php
                                    Icons_Manager::render_icon($settings['separator_icon'], ['aria-hidden' => 'true']);
                                    ?>
                                </span>
                                <?php
                            }
                            ?>
                        </span>
                    <?php } ?>
                </div>

                <div class="eead-dual-sec-button">
                    <a <?php $this->print_render_attribute_string('sec-button'); ?>>
                        <span>
                            <?php
                            echo esc_html($settings['sec_button_text']);
                            ?>
                        </span>
                        <?php
                        if ($settings['sec_button_icon']['value'] !== '') {
                            ?>
                            <?php
                            Icons_Manager::render_icon($settings['sec_button_icon'], ['aria-hidden' => 'true']);

                        }
                        ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

}
