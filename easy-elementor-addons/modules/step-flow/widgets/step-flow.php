<?php

namespace EasyElementorAddons\Modules\StepFlow\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class StepFlow extends Widget_Base {

    public function get_name() {
        return 'eead-step-flow';
    }

    public function get_title() {
        return esc_html__('Step Flow', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-step-flow';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'step_flow_settings_section', [
                'label' => esc_html__('Step Flow', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'selected_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ]
            ]
        );

        $this->add_control(
            'badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Badge', 'easy-elementor-addons'),
                'description' => esc_html__('Leave blank to hide the Badge', 'easy-elementor-addons'),
                'default' => esc_html__('Step 1', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Title', 'easy-elementor-addons'),
                'default' => esc_html__('Title', 'easy-elementor-addons'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Description', 'easy-elementor-addons'),
                'default' => 'Lorem ipsum dolor, sit amet, consectetur adipisicing elit. Description repellendus dignissimos dolorum sint temporibus corporis!',
            ]
        );

        $this->add_control(
            'show_readmore', [
                'label' => esc_html__('Show Read More Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'readmore_link', [
                'label' => esc_html__('Read More Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#'
                ],
                'condition' => [
                    'show_readmore' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'readmore_text', [
                'label' => esc_html__('Read More Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Read More', 'easy-elementor-addons'),
                'default' => esc_html__('Read More', 'easy-elementor-addons'),
                'condition' => [
                    'show_readmore' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'additional_settings', [
                'label' => esc_html__('Additional Settings', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'separator' => 'before',
                'default' => 'h4',
                'options' => eead_html_tags(),
            ]
        );

        $this->add_control(
            'content_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'show_direction', [
                'label' => esc_html__('Show Direction', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'arrow_style', [
                'label' => esc_html__('Direction Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'style4' => esc_html__('Style 4', 'easy-elementor-addons'),
                    'style5' => esc_html__('Style 5', 'easy-elementor-addons'),
                    'style6' => esc_html__('Style 6', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'show_direction' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_section', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 6,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'icon_border',
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
                'selector' => '{{WRAPPER}} .eead-steps-icon'
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'icon_box_shadow',
                'selector' => '{{WRAPPER}} .eead-steps-icon'
            ]
        );

        $this->add_responsive_control(
            'icon_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-icon-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'badge_style_section', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'badge!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_h_position', [
                'label' => esc_html__('Horizontal Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-sf-h-pos:{{VALUE}}',
                ],
                'default' => 'right',
                'toggle' => false,
            ]
        );

        $this->add_responsive_control(
            'badge_offset_left', [
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
                    '{{WRAPPER}} .eead-steps-label' => 'left:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'badge_h_position' => 'left',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_offset_right', [
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
                    '{{WRAPPER}} .eead-steps-label' => 'right:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'badge_h_position' => 'right',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_v_position', [
                'label' => esc_html__('Vertical Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-sf-v-pos:{{VALUE}}',
                ],
                'default' => 'top',
                'toggle' => false,
            ]
        );

        $this->add_responsive_control(
            'badge_offset_top', [
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
                    '{{WRAPPER}} .eead-steps-label' => 'top:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'badge_v_position' => 'top',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_offset_bottom', [
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
                    '{{WRAPPER}} .eead-steps-label' => 'bottom:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'badge_v_position' => 'bottom',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .eead-steps-label',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'badge_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'badge_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-label' => 'background: {{VALUE}};',
                ]
            ]
        );


        $this->add_responsive_control(
            'badge_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'badge_border',
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
                'selector' => '{{WRAPPER}} .eead-steps-label',
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style_section', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-steps-title'
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_hover_color', [
                'label' => esc_html__('Hover Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'link[url]!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-title a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-steps-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'description_style', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .eead-step-description'
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-description' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'description_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-description' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_direction_style', [
                'label' => esc_html__('Direction', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_direction' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'direction_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-direction svg > path' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .eead-step-direction svg marker > path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'direction_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-direction' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'line_width', [
                'label' => esc_html__('Line Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 8,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 0.1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-direction svg path' => 'stroke-width: {{SIZE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dash_gap', [
                'label' => esc_html__('Dash Gap', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow' => '--eead-stepflow-dash-gap: {{SIZE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dash_length', [
                'label' => esc_html__('Dash Length', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow' => '--eead-stepflow-dash-length: {{SIZE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'direction_offset_y', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -500,
                        'max' => 500,
                    ]
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow' => '--eead-stepflow-offset-y: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'direction_offset_x', [
                'label' => esc_html__('Horizontal Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow' => '--eead-stepflow-offset-x: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'direction_angle', [
                'label' => esc_html__('Rotate', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow' => '--eead-stepflow-direction-angle: {{SIZE}}deg;',
                ]
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'readmore_style', [
                'label' => esc_html__('Read More', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_readmore' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'readmore_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-step-flow-readmore',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'readmore_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'readmore_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'readmore_tabs'
        );

        $this->start_controls_tab(
            'readmore_tab_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'readmore_color_normal', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_normal', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_border_color_normal', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore' => 'border: 1px solid {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'readmore_tab_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'readmore_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore:hover' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-step-flow-readmore:hover' => 'border: 1px solid {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('title', 'class', 'eead-steps-title');

        $this->add_inline_editing_attributes('description', 'advanced');
        $this->add_render_attribute('description', 'class', 'eead-step-description');

        $this->add_render_attribute('badge', 'class', 'eead-steps-label');
        $this->add_inline_editing_attributes('badge', 'none');

        if (!empty($settings['readmore_link']['url'])) {
            $this->add_link_attributes('link', $settings['readmore_link']);
            $this->add_inline_editing_attributes('link', 'basic', 'title');

            $title = sprintf(
                '<a %s>%s</a>', $this->get_render_attribute_string('link'), esc_html($settings['title'])
            );
        } else {
            $this->add_inline_editing_attributes('title', 'basic');
            $title = esc_html($settings['title']);
        }
        ?>
        <div class="eead-step-flow">

            <div class="eead-steps-icon-box">
                <?php
                $this->render_arrow();
                ?>

                <span class="eead-steps-icon">
                    <?php
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                    ?>
                </span>

                <?php
                if ($settings['badge']) { ?>
                    <span <?php $this->print_render_attribute_string('badge'); ?>>
                        <?php echo esc_html($settings['badge']); ?>
                    </span>
                <?php }
                ?>
            </div>

            <?php printf('<%1$s %2$s>%3$s</%1$s>', esc_attr(eead_check_allowed_html_tags($settings['title_tag'])), $this->get_render_attribute_string('title'), $title); ?>

            <?php if ($settings['description']) { ?>
                <p <?php $this->print_render_attribute_string('description'); ?>><?php echo wp_kses_post($settings['description']); ?></p>
            <?php } ?>

            <?php if ($settings['show_readmore'] == 'yes' && !empty($settings['readmore_text']) && !empty($settings['readmore_link']['url'])) { ?>
                <a href="<?php echo esc_url($settings['readmore_link']['url']); ?>" class="eead-step-readmore"><?php echo esc_html($settings['readmore_text']); ?></a>
            <?php } ?>

        </div>
        <?php
    }

    protected function render_arrow() {
        $settings = $this->get_settings_for_display();
        $widgetID = $this->get_id();
        if ($settings['show_direction'] === 'yes') {
            echo '<span class="eead-step-direction">';
            switch ($settings['arrow_style']) {
                case 'style1':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path marker-end="url(#' . esc_attr($widgetID) . ')" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(315 400 400)" d="m150 150 500 500"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;

                case 'style2':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path d="M156.5 156.5q312 21 487 487" marker-end="url(#' . esc_attr($widgetID) . ')" transform="rotate(310 400 400)" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;

                case 'style3':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path d="M150 150q427 233 250 250-226 33 250 250" marker-end="url(#' . esc_attr($widgetID) . ')" transform="rotate(315 400 400)" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;

                case 'style4':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path d="M150 150q5 391 250 250 192-112 250 250" marker-end="url(#' . esc_attr($widgetID) . ')" transform="rotate(315 400 400)" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;

                case 'style5':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path d="M158.145 150q-108 408 500 500" marker-end="url(#' . esc_attr($widgetID) . ')" transform="rotate(315 400 400)" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;

                case 'style6':
                    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><path d="M159.5 159.5q413 539 240.5 240.5Q85.5-126.5 640.5 640.5" marker-end="url(#' . esc_attr($widgetID) . ')" transform="rotate(315 400 400)" stroke-width="10" stroke="hsl(227, 71%, 57%)" fill="none" stroke-linecap="round" stroke-linejoin="round"/><defs><marker markerWidth="5" markerHeight="5" refX="2.5" refY="2.5" viewBox="0 0 5 5" orient="auto" id="' . esc_attr($widgetID) . '"><path fill="hsl(227, 71%, 57%)" d="m0 5 1.667-2.5L0 0l5 2.5z"/></marker></defs></svg>';
                    break;
            }
            echo '</span>';

        }
    }

}
