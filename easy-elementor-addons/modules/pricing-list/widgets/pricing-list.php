<?php

namespace EasyElementorAddons\Modules\PricingList\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Pricing List Widget
 */
class PricingList extends Widget_Base {

    public function get_name() {
        return 'eead-pricing-list';
    }

    public function get_title() {
        return esc_html__('Pricing List', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-pricing-list';
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
            'image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumb',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'full'
            ]
        );

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Pricing Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Pricing'
            ]
        );

        $repeater->add_control(
            'price', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '500'
            ]
        );

        $repeater->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at.',
                'placeholder' => esc_html__('Type your item description here', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ]
            ]
        );

        $this->add_control(
            'pricing_lists', [
                'label' => esc_html__('Lists', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => 'Item 1',
                        'price' => '$10',
                        'description' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at.'
                    ],
                    [
                        'title' => 'Item 2',
                        'price' => '$20',
                        'description' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at.'
                    ],
                    [
                        'title' => 'Item 3',
                        'price' => '$30',
                        'description' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at.'
                    ]
                ],
                'title_field' => '{{{ title }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'pricing_column', [
                'label' => esc_html__('Grid Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    '1' => esc_html__('1', 'easy-elementor-addons'),
                    '2' => esc_html__('2', 'easy-elementor-addons'),
                    '3' => esc_html__('3', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list' => 'grid-template-columns: repeat({{SIZE}}, 1fr);'
                ],
            ]
        );

        $this->add_responsive_control(
            'h_alignment', [
                'label' => esc_html__('Horizontal Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'row',
                'options' => [
                    'row' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item' => 'flex-direction: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'v_alignment', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item' => 'align-items: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'price_list_spacing', [
                'label' => esc_html__('Spacing Between List', 'easy-elementor-addons'),
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
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_width', [
                'label' => esc_html__('Image Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-image' => 'flex-basis: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'price_position', [
                'label' => esc_html__('Price Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => 'Inline With Heading',
                    'style2' => 'Over Image',
                ],
                'default' => 'style1'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_pricing_list', [
                'label' => esc_html__('Pricing Item', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'pricing_item_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'pricing_item_border',
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
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'pricing_item_shadow',
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item'
            ]
        );

        $this->add_responsive_control(
            'pricing_item_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'pricing_item_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'image_border',
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
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-image'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'image_shadow',
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-image'
            ]
        );

        $this->add_responsive_control(
            'image_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-title'
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_bg_color', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'title_border_color',
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
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header'
            ]
        );

        $this->add_responsive_control(
            'title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'title_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-description'
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-description' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_style_section', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'price_style', [
                'label' => esc_html__('Price Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'label_block' => false,
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'framed' => esc_html__('Framed', 'easy-elementor-addons'),
                    'stacked' => esc_html__('Stacked', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'price_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price'
            ]
        );

        $this->add_responsive_control(
            'price_circle_size', [
                'label' => esc_html__('Price Outer Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 70,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ]
                ],
                'condition' => [
                    'price_style!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'price_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'price_style' => 'framed',
                ]
            ]
        );

        $this->add_control(
            'price_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'price_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'color' => [
                    'default' => '#3858f4',
                ],
                'condition' => [
                    'price_style!' => 'framed',
                ],
                'selector' => '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price'
            ]
        );

        $this->add_responsive_control(
            'price_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'condition' => [
                    'price_style' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'price_radius_advanced_show', [
                'label' => esc_html__('Advanced Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'price_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'price_radius_advanced_show!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'price_radius_advanced', [
                'label' => esc_html__('Radius', 'easy-elementor-addons'),
                'description' => sprintf(__('For example: <b>%1s</b> or Go <a href="%2s" target="_blank">this link</a> and copy and paste the radius value.', 'easy-elementor-addons'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
                'type' => Controls_Manager::TEXT,
                'size_units' => ['px', '%'],
                'default' => '75% 25% 43% 57% / 46% 29% 71% 54%',
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-price' => 'border-radius: {{VALUE}};'
                ],
                'condition' => [
                    'price_radius_advanced_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'enable_pricing_divider', [
                'label' => esc_html__('Enable Divider between Title & Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'divider_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header:before' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_pricing_divider' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'divider_border_style', [
                'label' => esc_html__('Border Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'label_block' => false,
                'options' => [
                    'solid' => esc_html__('Solid', 'easy-elementor-addons'),
                    'double' => esc_html__('Double', 'easy-elementor-addons'),
                    'dotted' => esc_html__('Dotted', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons'),
                    'groove' => esc_html__('Groove', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header:before' => 'border-bottom-style: {{VALUE}};',
                ],
                'condition' => [
                    'enable_pricing_divider' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'divider_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE',
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header:before' => 'border-bottom-color: {{VALUE}}',
                ],
                'condition' => [
                    'enable_pricing_divider' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'divider_alignment', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header:before' => 'align-self: {{VALUE}};',
                ],
                'condition' => [
                    'enable_pricing_divider' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'divider_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-pricing-list .eead-pl-item-header' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_pricing_divider' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('pricing-list',
            'class', [
                'eead-pricing-list-container',
                'eead-pl-price-' . esc_attr($settings['price_style'])
            ]
        );
        ?>
        <div <?php $this->print_render_attribute_string('pricing-list'); ?>>
            <div class="eead-pricing-list">
                <?php
                if ($settings['pricing_lists']) {
                    foreach ($settings['pricing_lists'] as $lists) { ?>
                        <div class="eead-pl-item">
                            <?php
                            $has_link = false;
                            if (isset($lists['link']['url']) && !empty($lists['link']['url'])) {
                                $has_link = true;
                                $link = $lists['link']['url'];
                            }
                            ?>
                            <?php if ($lists['image']['url']) { ?>
                                <div class="eead-pl-item-image">
                                    <?php
                                    if ($has_link) {
                                        $image = Group_Control_Image_Size::get_attachment_image_html($lists, 'thumb', 'image');
                                        printf('<a href=%1$s>%2$s</a>', esc_url($link), $image);
                                    } else {
                                        echo Group_Control_Image_Size::get_attachment_image_html($lists, 'thumb', 'image');
                                    }

                                    if ($settings['price_position'] == 'style2' && $lists['price']) {
                                        ?>
                                        <div class="eead-pl-item-price">
                                            <?php echo esc_html($lists['price']); ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>

                            <div class="eead-pl-item-content">
                                <div class="eead-pl-item-header">

                                    <?php if ($lists['title']) { ?>
                                        <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'])); ?> class="eead-pl-item-title">
                                            <?php
                                            if ($has_link) {
                                                printf('<a href=%1$s>%2$s</a>', esc_url($link), esc_html($lists['title']));
                                            } else {
                                                echo esc_html($lists['title']);
                                            }
                                            ?>
                                        </<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'])); ?>>
                                    <?php } ?>

                                    <?php
                                    if ($settings['price_position'] == 'style1' && $lists['price']) {
                                        ?>
                                        <div class="eead-pl-item-price">
                                            <?php echo esc_html($lists['price']); ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php if ($lists['description']) { ?>
                                    <div class="eead-pl-item-description">
                                        <?php echo esc_html($lists['description']); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                    }
                } ?>
            </div>
        </div>
        <?php
    }

}
