<?php

namespace EasyElementorAddons\Modules\PricingTable\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Pricing Table Widget
 */
class PricingTable extends Widget_Base {

    public function get_name() {
        return 'eead-pricing-table';
    }

    public function get_title() {
        return esc_html__('Pricing Table', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-pricing-table';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Pricing Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Pricing'
            ]
        );

        $this->add_control(
            'sub_title', [
                'label' => esc_html__('Sub Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'price', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '$500'
            ]
        );

        $this->add_control(
            'price_per', [
                'label' => esc_html__('Price Per(/month, /year)', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '/year'
            ]
        );

        $this->add_control(
            'tag', [
                'label' => esc_html__('Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Popular'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list', [
                'label' => esc_html__('Features', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'feature_icon', [
                'label' => esc_html__('Button Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-check-alt',
                    'library' => 'iconfont'
                ],
            ]
        );

        $this->add_control(
            'feature_list', [
                'label' => esc_html__('Plan Feature List', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list' => 'Enter Features List'
                    ],
                    [
                        'list' => 'Enter Features List'
                    ],
                    [
                        'list' => 'Enter Features List'
                    ],
                    [
                        'list' => 'Enter Features List'
                    ]
                ],
                'title_field' => '{{{ list }}}',
            ]
        );

        $this->add_control(
            'link_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Buy Now'
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Button Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false
                ],
            ]
        );

        $this->add_control(
            'link_icon', [
                'label' => esc_html__('Button Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-rounded-right',
                    'library' => 'iconfont'
                ],
            ]
        );

        $this->add_control(
            'header_icon', [
                'label' => esc_html__('Header Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'style4' => esc_html__('Style 4', 'easy-elementor-addons'),
                    'style5' => esc_html__('Style 5', 'easy-elementor-addons'),
                    'style6' => esc_html__('Style 6', 'easy-elementor-addons'),
                    'style7' => esc_html__('Style 7', 'easy-elementor-addons'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'container_style', [
                'label' => esc_html__('Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_box_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'pricing_box_border',
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
                'selector' => '{{WRAPPER}} .eead-pricing-table'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'pricing_box_shadow',
                'selector' => '{{WRAPPER}} .eead-pricing-table'
            ]
        );

        $this->add_responsive_control(
            'pricing_box_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'pricing_box_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-box-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header_style', [
                'label' => esc_html__('Header', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout!' => 'style1'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'header_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-pricing-table:not(.style5) .eead-pricing-header, {{WRAPPER}} .eead-pricing-table.style5 .eead-pricing-header:before',
                'condition' => [
                    'layout!' => 'style7'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'header_background7',
                'exclude' => ['gradient', 'classic'],
                'exclude' => ['color'],
                'selector' => '{{WRAPPER}} .eead-pricing-table.style7 .eead-pricing-header',
                'condition' => [
                    'layout' => 'style7'
                ]
            ]
        );

        $this->add_control(
            'header_background7_overlay', [
                'label' => esc_html__('Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-header-overlay-color: {{VALUE}}',
                ],
                'condition' => [
                    'layout' => 'style7'
                ]
            ]
        );

        $this->add_responsive_control(
            'header_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-header-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header_icon_style', [
                'label' => esc_html__('Header Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-header-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-pricing-table .eead-header-icon svg' => 'fill: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'header_icon_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-header-icon'
            ]
        );

        $this->add_responsive_control(
            'header_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-pricing-table .eead-header-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_icon_bg_size', [
                'label' => esc_html__('Icon Background Size', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-header-icon-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_icon_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-header-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_icon_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-header-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'header_shadow',
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-header-icon'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-title',
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-title' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sub_title_style', [
                'label' => esc_html__('Sub Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'sub_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-sub-title',
            ]
        );

        $this->add_control(
            'sub_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-sub-title' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_style', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'price_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-price .eead-price',
            ]
        );

        $this->add_control(
            'price_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-price .eead-price' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'price_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_per_style', [
                'label' => esc_html__('Price Per', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_per_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-price-per' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'price_per_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-price-per'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'feature_list_style', [
                'label' => esc_html__('Features List', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'feature_list_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table ul.eead-pricing-listing li' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-pricing-table ul.eead-pricing-listing li svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'feature_list_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table ul.eead-pricing-listing li i' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'feature_list_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table ul.eead-pricing-listing li',
            ]
        );

        $this->add_responsive_control(
            'feature_list_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-list-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'enable_listing_separator', [
                'label' => esc_html__('Enable Separator', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'feature_list_sep_size', [
                'label' => esc_html__('Separator Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-list-sep-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['enable_listing_separator' => 'yes']
            ]
        );

        $this->add_control(
            'feature_list_sep_color', [
                'label' => esc_html__('Separator Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-list-sep-color: {{VALUE}}'
                ],
                'condition' => ['enable_listing_separator' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'feature_list_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table ul.eead-pricing-listing' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a',
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'button_icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => esc_html__('Before', 'easy-elementor-addons'),
                    'row' => esc_html__('After', 'easy-elementor-addons')
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a' => 'flex-direction: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'button_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'toggle' => false,
                'options' => [
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-shrink',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'easy-elementor-addons'),
                        'icon' => 'eicon-grow',
                    ]
                ],
                'selectors_dictionary' => [
                    'center' => 'display:inline-flex;',
                    'stretch' => 'display:flex;justify-content:center;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a' => '{{VALUE}}'
                ],
            ]
        );

        $this->start_controls_tabs(
            'button_tabs'
        );

        $this->start_controls_tab(
            'button_style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a',
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
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_hover_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_bg_hover_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a:hover',
            ]
        );

        $this->add_control(
            'button_border_hover_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a:hover' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-button a:hover'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tag_style_section', [
                'label' => esc_html__('Tag', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'tag_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-table .eead-pricing-tag',
            ]
        );

        $this->add_control(
            'tag_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-tag-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'tag_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-table' => '--eead-pt-tag-bg-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'tag_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
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
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $pricing_class = array(
            'eead-pricing-table',
            $settings['layout']
        );
        ?>

        <div class="<?php echo esc_attr(implode(' ', array_filter($pricing_class))); ?>">
            <?php
            if ($settings['tag']) {
                echo '<span class="eead-pricing-tag eead-pt-tag-' . esc_attr($settings['tag_style']) . '">' . esc_html($settings['tag']) . '</span>';
            }
            ?>

            <div class="eead-pricing-header">
                <?php if ($settings['header_icon']['value']) { ?>
                    <div class="eead-header-icon">
                        <?php Icons_Manager::render_icon($settings['header_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                    <?php
                }
                $this->get_pricing_header();

                $this->get_pricing_price();
                ?>
            </div>

            <div class="eead-pricing-body">
                <?php $this->get_pricing_list(); ?>

                <?php if (!empty($settings['link']['url'])) { ?>
                    <div class="eead-pricing-button">
                        <a href="<?php echo esc_url($settings['link']['url']); ?>" <?php echo ($settings['link']['is_external'] ? ' target="_blank"' : '') . ($settings['link']['nofollow'] ? ' rel="nofollow"' : ''); ?>>
                            <?php echo wp_kses_post($settings['link_text']); ?>
                            <?php Icons_Manager::render_icon($settings['link_icon'], ['aria-hidden' => 'true']); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    protected function get_pricing_header() {
        $settings = $this->get_settings_for_display();
        if ($settings['title']) {
            ?>
            <h2 class="eead-pricing-title"><?php echo esc_html($settings['title']); ?></h2>
            <?php
        }

        if ($settings['sub_title']) {
            ?>
            <p class="eead-pricing-sub-title"><?php echo esc_html($settings['sub_title']); ?></p>
            <?php
        }
    }

    protected function get_pricing_price() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-pricing-price">
            <span class="eead-price"><?php echo esc_html($settings['price']); ?></span>
            <span class="eead-price-per"><?php echo esc_html($settings['price_per']); ?></span>
        </div>
        <?php
    }

    protected function get_pricing_list() {
        $settings = $this->get_settings_for_display();
        if ($settings['feature_list']) {
            echo '<ul class="eead-pricing-listing">';
            foreach ($settings['feature_list'] as $item) {
                echo '<li>';
                Icons_Manager::render_icon($item['feature_icon'], ['aria-hidden' => 'true']);
                echo wp_kses_post($item['list']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

}
