<?php

namespace EasyElementorAddons\Modules\VerticalTimeline\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class VerticalTimeline extends Widget_Base {

    public function get_name() {
        return 'eead-vertical-timeline';
    }

    public function get_title() {
        return esc_html__('Vertical Timeline', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-vertical-timeline';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'items', [
                'label' => esc_html__('Items', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'enable', [
                'label' => esc_html__('Enable', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'item_image',
                'default' => 'full'
            ]
        );

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => array('active' => true)
            ]
        );

        $repeater->add_control(
            'meta', [
                'label' => esc_html__('Meta', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'point_heading', [
                'label' => esc_html__('Point', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

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
            'button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'button_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Read More'
            ]
        );

        $repeater->add_control(
            'button_url', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ]
            ]
        );

        $this->add_control(
            'item_list', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Item #1', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.',
                        'meta' => 'Thursday, August 31, 2022',
                    ],
                    [
                        'title' => esc_html__('Item #2', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.',
                        'meta' => 'Thursday, August 29, 2023',
                    ],
                    [
                        'title' => esc_html__('Item #3', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.',
                        'meta' => 'Thursday, August 28, 2024',
                    ],
                    [
                        'title' => esc_html__('Item #4', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.',
                        'meta' => 'Thursday, August 27, 2025',
                    ]
                ],
                'title_field' => '{{{ title }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
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

        $this->add_control(
            'layout_style', [
                'label' => esc_html__('Layout Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'toggle' => false,
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
                ]
            ]
        );

        $this->add_control(
            'text_alignment_left', [
                'label' => esc_html__('Left Blocks Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'toggle' => false,
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
                    '{{WRAPPER}} .eead-card-center .eead-vt-each-wrap:nth-child(odd), {{WRAPPER}} .eead-card-left .eead-vt-each-wrap' => 'text-align: {{VALUE}}',
                ],
                'condition' => [
                    'layout_style' => ['left', 'center']
                ]
            ]
        );

        $this->add_control(
            'text_alignment_right', [
                'label' => esc_html__('Right Blocks Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'toggle' => false,
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
                    '{{WRAPPER}} .eead-card-center .eead-vt-each-wrap:nth-child(even), {{WRAPPER}} .eead-card-right .eead-vt-each-wrap' => 'text-align: {{VALUE}}',
                ],
                'condition' => [
                    'layout_style' => ['right', 'center']
                ]
            ]
        );

        $this->add_responsive_control(
            'block_spacing', [
                'label' => esc_html__('Blocks Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-inner' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_width', [
                'label' => esc_html__('Content Width (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 60,
                ],
                'condition' => [
                    'layout_style!' => 'center',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vertical-timeline .eead-card-right .eead-vt-each-wrap, {{WRAPPER}} .eead-vertical-timeline .eead-card-left .eead-vt-each-wrap' => 'width: {{SIZE}}%;',
                    '{{WRAPPER}} .eead-vertical-timeline .eead-card-right .eead-vt-inner:before' => 'left: calc(100% - {{SIZE}}%);',
                    '{{WRAPPER}} .eead-vertical-timeline .eead-card-left .eead-vt-inner:before' => 'left: {{SIZE}}%;'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style Tab */
        $this->start_controls_section(
            'time_point_style', [
                'label' => esc_html__('Time Point', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'point_size', [
                'label' => esc_html__('Point Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vertical-timeline' => '--eead-vt-point-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vt-point svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'time_point_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'time_point_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point i' => 'color: {{VALUE}}; border-color:  {{VALUE}};',
                    '{{WRAPPER}} .eead-vt-point svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'time_point_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vertical-timeline' => '--eead-vt-point-border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'time_point_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-point' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'timeline_heading',
            [
                'label' => esc_html__('Time Line', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'timeline_color', [
                'label' => esc_html__('Time Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vertical-timeline .eead-vt-inner:before, {{WRAPPER}} .eead-vt-point:before, {{WRAPPER}} .eead-vt-point:after' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'timeline_width', [
                'label' => esc_html__('Time Line Width', 'easy-elementor-addons'),
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
                    'size' => 1,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vertical-timeline .eead-vt-inner:before' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vt-point:before, {{WRAPPER}} .eead-vt-point:after' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'meta_style', [
                'label' => esc_html__('Meta', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'meta_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'meta_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta, {{WRAPPER}} .eead-vertical-timeline .eead-vt-meta:before' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'meta_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'meta_border',
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
                'selector' => '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'meta_box_shadow',
                'selector' => '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta'
            ]
        );

        $this->add_responsive_control(
            'meta_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'meta_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-each-wrap .eead-vt-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['left', 'right'],
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vertical-timeline .eead-vt-each-wrap .eead-vt-meta' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-content' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'content_border',
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
                'selector' => '{{WRAPPER}} .eead-vt-content'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .eead-vt-content'
            ]
        );

        $this->add_responsive_control(
            'content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'allowed_dimensions' => ['left', 'right'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-content' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_image_tab',
            [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'content_image_heading',
            [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'content_image_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_image_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_title_tab',
            [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'content_title_heading',
            [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'content_title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-vt-title'
            ]
        );

        $this->add_responsive_control(
            'content_title_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_desc_tab',
            [
                'label' => esc_html__('Desc', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'content_desc_heading',
            [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'content_desc_color', [
                'label' => esc_html__('Description Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-description' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_desc_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-vt-description'
            ]
        );

        $this->add_responsive_control(
            'content_desc_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-description' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'readmore_style', [
                'label' => esc_html__('Read More', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'readmore_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-vt-more-button a',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'readmore_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'readmore_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'readmore_border',
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
                'selector' => '{{WRAPPER}} .eead-vt-more-button a',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'read_more_shadow',
                'selector' => '{{WRAPPER}} .eead-vt-more-button a'
            ]
        );

        $this->add_responsive_control(
            'readmore_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-vt-more-button a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_normal', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button a' => 'background: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-vt-more-button a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button a:hover' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vt-more-button a:hover' => 'border: 1px solid {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-vertical-timeline">
            <div class="<?php echo 'eead-card-' . esc_attr($settings['layout_style']); ?>">
                <div class="eead-vt-inner">
                    <?php
                    foreach ($settings['item_list'] as $key => $item) { ?>
                        <?php
                        if ($item['enable'] != 'yes') {
                            continue;
                        }
                        ?>
                        <div class="eead-vt-each-wrap">
                            <div class="eead-vt-point">
                                <?php
                                Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                                ?>
                                <div class="eead-vt-meta">
                                    <span><?php echo esc_html($item['meta']); ?></span>
                                </div>
                            </div>

                            <div class="eead-vt-card">
                                <div class="eead-vt-content">
                                    <?php if (!empty($item['image']['url'])) { ?>
                                        <div class="eead-vt-image">
                                            <?php
                                            echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($item, 'item_image', 'image'));
                                            ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($item['title']) { ?>
                                        <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])); ?> class="eead-vt-title">
                                            <?php
                                            echo esc_html($item['title']);
                                            ?>
                                        </<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])); ?>>
                                    <?php } ?>

                                    <?php if ($item['description']) { ?>
                                        <div class="eead-vt-description">
                                            <?php echo wp_kses_post($item['description']); ?>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (!empty($item['button_url']['url'])) {
                                        $this->add_link_attributes('button_url' . $key, $item['button_url']);
                                        ?>
                                        <div class="eead-vt-more-button">
                                            <a <?php $this->print_render_attribute_string('button_url' . $key); ?>>
                                                <?php echo esc_html($item['button_text']); ?>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
        <?php
    }
}
