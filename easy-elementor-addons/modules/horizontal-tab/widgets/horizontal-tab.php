<?php

namespace EasyElementorAddons\Modules\HorizontalTab\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class HorizontalTab extends Widget_Base {

    public function get_name() {
        return 'eead-horizontal-tab';
    }

    public function get_title() {
        return esc_html__('Horizontal Tab', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-horizontal-tab';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon', [
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

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Tab Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Tab Title'
            ]
        );

        $repeater->add_control(
            'content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'wisiwyg',
                'options' => [
                    'wisiwyg' => esc_html__('WISIWYG', 'easy-elementor-addons'),
                    'elementor_template' => esc_html__('Elementor Template', 'easy-elementor-addons'),
                    'page' => esc_html__('Page', 'easy-elementor-addons'),
                ]
            ]
        );

        $repeater->add_control(
            'page', [
                'label' => esc_html__('Select Page', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'multiple' => false,
                'options' => $this->get_pages(),
                'condition' => ['content_type' => 'page']
            ]
        );

        $repeater->add_control(
            'wisiwyg_content', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__('Type your description here', 'easy-elementor-addons'),
                'condition' => ['content_type' => 'wisiwyg']
            ]
        );

        $repeater->add_control(
            'elementor_template', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_elementor_templates(),
                'label_block' => 'true',
                'condition' => ['content_type' => 'elementor_template']
            ]
        );

        $repeater->add_control(
            'enable', [
                'label' => esc_html__('Enable', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'tabs', [
                'label' => esc_html__('Add Tabs', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Tab Title 1',
                        'wisiwyg_content' => 'Ut posuere bibendum pretium. Nulla sit amet felis sem. Donec eu elit efficitur, vehicula quam sit amet, sodales elit. Praesent ac velit arcu. Sed volutpat vitae nulla sed fermentum. Praesent at pulvinar diam, a iaculis justo. In ullamcorper nec risus sit amet malesuada. Sed tempor, risus sit amet vestibulum dignissim, purus magna venenatis velit, sed facilisis diam arcu at leo. Donec nec lacus in ligula pretium finibus a lobortis ipsum. Nullam eu sem quis magna aliquet cursus. Nam vitae faucibus lorem. Praesent maximus, magna et volutpat scelerisque, neque quam hendrerit ante, nec eleifend est nunc a orci.'
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Tab Title 2',
                        'wisiwyg_content' => 'Aenean facilisis accumsan nunc, vel maximus ipsum dictum ut. Sed in mauris commodo magna faucibus accumsan. Nunc non purus mi. Phasellus aliquet facilisis orci. Nullam vel tempor est. Aliquam eu elit sit amet nunc ullamcorper imperdiet. Phasellus porta egestas dolor sodales porttitor. Nunc mollis purus id nibh tempus pulvinar. In egestas et magna eu aliquam. Nunc dapibus massa metus, tempor lobortis risus cursus vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed dignissim rutrum tortor, vitae viverra augue tincidunt at. Sed leo nisl, congue ut justo in.'
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Tab Title 3',
                        'wisiwyg_content' => 'Donec justo eros, luctus quis scelerisque id, ultricies sit amet odio. Vestibulum aliquam efficitur eleifend. Praesent dignissim faucibus ex vel sodales. Morbi aliquet libero at augue pharetra vehicula. Cras dapibus lorem efficitur nunc euismod convallis. Nunc molestie risus id lacinia consequat. Integer iaculis orci in ipsum vestibulum, non mattis justo ornare. Cras et lorem tempor ligula suscipit mollis. Nulla vitae augue non leo tempus finibus.'
                    ]
                ],
                'title_field' => '{{{title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'tab_content_animation', [
                'label' => esc_html__('Content Display Animation', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => eead_show_animations_alt()
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_container_style', [
                'label' => esc_html__('Tab Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'tab_container_background', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-container' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'tab_container_border',
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
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_container_shadow',
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-container'
            ]
        );

        $this->add_responsive_control(
            'tab_container_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_style', [
                'label' => esc_html__('Tab Bar', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'tab_background', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'tab_border',
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
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_box_shadow',
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs'
            ]
        );

        $this->add_responsive_control(
            'tab_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_button_style', [
                'label' => esc_html__('Tab Buttons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'tab_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab'
            ]
        );

        $this->add_control(
            'tab_icon_heading', [
                'label' => esc_html__('Tab Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'tab_icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'top' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-direction: column; text-align: center',
                    'left' => 'flex-direction: row',
                    'right' => 'flex-direction: row-reverse',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => '{{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'tab_button_heading', [
                'label' => esc_html__('Tab Buttons', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'tab_buttons_alignment', [
                'label' => esc_html__('Buttons Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-close',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-stretch',
                    ]
                ],
                'default' => 'none',
                'selectors_dictionary' => [
                    'stretch' => 'flex-grow: 1; justify-content: center;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => '{{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tabs_buttons_position', [
                'label' => esc_html__('Tabs Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'selectors_dictionary' => [
                    'left' => 'justify-content: flex-start',
                    'center' => 'justify-content: center',
                    'right' => 'justify-content: flex-end'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => '{{VALUE}}',
                ],
                'condition' => [
                    'tab_buttons_alignment' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_buttons_spacing', [
                'label' => esc_html__('Button Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tabs' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'tab_buttons_shape', [
                'label' => esc_html__('Pre Defined Button Shape', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'Trapezoid' => esc_html__('Trapezoid', 'easy-elementor-addons'),
                    'Right Angled Trapezoid' => esc_html__('Right Angled Trapezoid', 'easy-elementor-addons'),
                    'Left Angled Trapezoid' => esc_html__('Left Angled Trapezoid', 'easy-elementor-addons'),
                    'Parallelogram' => esc_html__('Parallelogram', 'easy-elementor-addons'),
                    'Bevel' => esc_html__('Bevel', 'easy-elementor-addons'),
                    'Rabbet' => esc_html__('Rabbet', 'easy-elementor-addons'),
                    'Left Point' => esc_html__('Left Point', 'easy-elementor-addons'),
                    'Right Point' => esc_html__('Right Point', 'easy-elementor-addons'),
                    'Left Chevron' => esc_html__('Left Chevron', 'easy-elementor-addons'),
                    'Right Chevron' => esc_html__('Right Chevron', 'easy-elementor-addons'),
                    'Message' => esc_html__('Message Box', 'easy-elementor-addons'),
                ],
                'selectors_dictionary' => [
                    'none' => 'none',
                    'Trapezoid' => 'clip-path:polygon(20px 0%, calc(100% - 20px) 0%, 100% 100%, 0% 100%);--eead-horizontal-tab-padding-left-extra: 20px;--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Right Angled Trapezoid' => 'clip-path:polygon(0 0, calc(100% - 20px) 0, 100% 100%, 0% 100%);--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Left Angled Trapezoid' => 'clip-path: polygon(20px 0%, 100% 0, 100% 100%, 0% 100%);--eead-horizontal-tab-padding-left-extra: 20px;',
                    'Parallelogram' => 'clip-path:polygon(20px 0%, 100% 0%, calc(100% - 20px) 100%, 0% 100%);--eead-horizontal-tab-padding-left-extra: 20px;--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Bevel' => 'clip-path:polygon(10px 0%, calc(100% - 10px) 0%, 100% 10px, 100% calc(100% - 10px), calc(100% - 10px) 100%, 10px 100%, 0% calc(100% - 10px), 0% 10px);--eead-horizontal-tab-padding-left-extra: 10px;--eead-horizontal-tab-padding-right-extra: 10px;;',
                    'Rabbet' => 'clip-path:polygon(0% 10px, 10px 10px, 10px 0%, calc(100% - 10px) 0%, calc(100% - 10px) 10px, 100% 10px, 100% calc(100% - 10px), calc(100% - 10px) calc(100% - 10px), calc(100% - 10px) 100%, 10px 100%, 10px calc(100% - 10px), 0% calc(100% - 10px));--eead-horizontal-tab-padding-left-extra: 10px;--eead-horizontal-tab-padding-right-extra: 10px;',
                    'Left Point' => 'clip-path:polygon(20px 0%, 100% 0%, 100% 100%, 20px 100%, 0% 50%);--eead-horizontal-tab-padding-left-extra: 20px;',
                    'Right Point' => 'clip-path:polygon(0% 0%, calc(100% - 20px) 0%, 100% 50%, calc(100% - 20px) 100%, 0% 100%);--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Left Chevron' => 'clip-path:polygon(100% 0%, calc(100% - 20px) 50%, 100% 100%, 20px 100%, 0% 50%, 20px 0%);--eead-horizontal-tab-padding-left-extra: 20px;--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Right Chevron' => 'clip-path:polygon(calc(100% - 20px) 0%, 100% 50%, calc(100% - 20px) 100%, 0% 100%, 20px 50%, 0% 0%);--eead-horizontal-tab-padding-left-extra: 20px;--eead-horizontal-tab-padding-right-extra: 20px;',
                    'Message' => 'clip-path:polygon(0% 0%, 100% 0%, 100% calc(100% - 15px), calc(100% - 25px) calc(100% - 15px), calc(100% - 25px) 100%, calc(100% - 45px) calc(100% - 15px), 0% calc(100% - 15px));--eead-horizontal-tab-padding-bottom-extra: 15px;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => '{{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'tab_buttons_border',
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
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab',
                'condition' => [
                    'tab_buttons_shape' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_buttons_box_shadow',
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab',
                'condition' => [
                    'tab_buttons_shape' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_buttons_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'tab_buttons_shape' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab' => '--eead-horizontal-tab-padding-top: {{TOP}}{{UNIT}};--eead-horizontal-tab-padding-right: {{RIGHT}}{{UNIT}}; --eead-horizontal-tab-padding-bottom: {{BOTTOM}}{{UNIT}}; --eead-horizontal-tab-padding-left: {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'tab_button_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_button_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'tab_button_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_button_text_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab:hover svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'tab_buttons_shape' => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_active_tab', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'tab_button_bg_color_active', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab.eead-ht-active-tab' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_button_text_color_active', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab.eead-ht-active-tab' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab.eead-ht-active-tab svg *' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_button_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-tab.eead-ht-active-tab' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'tab_buttons_shape' => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_content_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'tab_content_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-content'
            ]
        );

        $this->add_control(
            'tab_content_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_content_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-contents' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'tab_content_border',
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
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-contents'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_content_box_shadow',
                'selector' => '{{WRAPPER}} .eead-horizontal-tab .eead-ht-contents'
            ]
        );

        $this->add_responsive_control(
            'tab_content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-tab .eead-ht-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        ?>
        <div class="eead-horizontal-tab">
            <div class="eead-ht-container">
                <div class="eead-ht-tabs">
                    <?php $this->get_tabs(); ?>
                </div>

                <div class="eead-ht-contents">
                    <?php $this->get_tab_content(); ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_tabs() {
        $settings = $this->
            get_settings_for_display();
        if (!empty($settings['tabs'])) {
            $i = 0;
            foreach ($settings['tabs'] as $tab) {
                if ($tab['enable'] == 'yes') {
                    $i++;
                    ?>
                    <div class="eead-ht-tab <?php echo ($i == 1 ? 'eead-ht-active-tab' : ''); ?>" data-tabid="<?php echo esc_attr($i); ?>">
                        <?php Icons_Manager::render_icon($tab['icon'], ['aria-hidden' => 'true']); ?>
                        <span><?php echo esc_html($tab['title']); ?></span>
                    </div>
                    <?php
                }
            }
        }
    }

    private function get_tab_content() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['tabs'])) {
            $i = 0;
            foreach ($settings['tabs'] as $tab) {
                if ($tab['enable'] == 'yes') {
                    $i++;
                    ?>
                    <div class="animated <?php echo $settings['tab_content_animation']; ?> eead-ht-content eead-ht-content-<?php echo esc_attr($i) . ' ' . ($i == 1 ? 'eead-ht-active-content' : ''); ?>">
                        <?php
                        if ($tab[
                            'content_type'] == 'page' && !empty($tab['page'])) {
                            $page_id = $tab['page'];
                            $elementor = get_post_meta($page_id, '_elementor_edit_mode', true);
                            if ($elementor) {
                                echo $this->elementor()->frontend->get_builder_content_for_display($page_id);
                            } else {
                                if (!is_wp_error($page_id)) {
                                    $content = $page_id->post_content;
                                }
                                echo apply_filters('the_content', $content);
                            }
                        } elseif ($tab['content_type'] == 'elementor_template') {
                            echo $this->elementor()->frontend->get_builder_content_for_display($tab['elementor_template']);
                        } elseif ($tab['content_type'] == 'wisiwyg' and $tab['wisiwyg_content']) {
                            echo wp_kses_post(parse_wisiwyg_content($tab['wisiwyg_content']));
                        }
                        ?>
                    </div>
                    <?php
                }
            }
        }
    }

    protected function get_elementor_templates() {
        $templates = $this->elementor()->templates_manager->get_source('local')->get_items();
        $types = [];

        if (empty($templates)) {
            $template_options = ['0' => esc_html__('Template Not Found!', 'easy-elementor-addons')];
        } else {
            $template_options = ['0' => esc_html__('Select Template', 'easy-elementor-addons')];

            foreach ($templates as $template) {
                $template_options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
                $types[$template['template_id']] = $template['type'];
            }
        }

        return $template_options;
    }

    protected function elementor() {
        return Plugin::$instance;
    }

    protected function get_pages() {
        $pages = get_pages();

        $_pages = [];
        foreach ($pages as $key => $object) {
            $_pages[$object->ID] = ucfirst($object->post_title);
        }

        return $_pages;
    }

}
