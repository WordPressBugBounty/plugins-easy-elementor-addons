<?php

namespace EasyElementorAddons\Modules\HorizontalTimeline\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class HorizontalTimeline extends Widget_Base {

    public function get_name() {
        return 'eead-horizontal-timeline';
    }

    public function get_title() {
        return esc_html__('Horizontal Timeline', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-vertical-timeline';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['mcustomscrollbar', 'owlcarousel'];
    }

    public function get_script_depends() {
        return ['mcustomscrollbar', 'owlcarousel'];
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
            'point_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => array(
                    'icon' => esc_html__('Icon', 'easy-elementor-addons'),
                    'text' => esc_html__('Text', 'easy-elementor-addons'),
                )
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
                ],
                'condition' => ['point_type' => 'icon']
            ]
        );

        $repeater->add_control(
            'point_text', [
                'label' => esc_html__('Point Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'A',
                'condition' => ['point_type' => 'text']
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
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos.',
                        'meta' => 'Thursday, August 31, 2020',
                    ],
                    [
                        'title' => esc_html__('Item #2', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos.',
                        'meta' => 'Friday, August 29, 2021',
                    ],
                    [
                        'title' => esc_html__('Item #3', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos.',
                        'meta' => 'Sunday, August 28, 2022',
                    ],
                    [
                        'title' => esc_html__('Item #4', 'easy-elementor-addons'),
                        'description' => 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos.',
                        'meta' => 'Monday, August 27, 2023',
                    ]
                ],
                'title_field' => '{{{title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'display_option', [
                'label' => esc_html__('Display Option', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'carousel',
                'options' => [
                    'scrollbar' => esc_html__('Scroll Bar', 'easy-elementor-addons'),
                    'carousel' => esc_html__('Carousel', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'meta_position', [
                'label' => esc_html__('Meta Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'alternate',
                'options' => [
                    'top' => esc_html__('Top', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                    'alternate' => esc_html__('Alternate', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_responsive_control(
            'block_width', [
                'label' => esc_html__('Block Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ]
                ],
                'size_units' => ['px', 'em', 'vw'],
                'default' => [
                    'size' => 340,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-card' => 'min-width: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_option' => 'scrollbar'
                ]
            ]
        );

        $this->add_responsive_control(
            'alignment', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
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
                    '{{WRAPPER}} .eead-htl-card' => 'text-align: {{VALUE}}',
                ]
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

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_settings', [
                'label' => esc_html__('Carousel Settings', 'easy-elementor-addons'),
                'condition' => [
                    'display_option' => 'carousel'
                ]
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
            'arrows', [
                'label' => esc_html__('Navigation Arrows', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();

        /* Style Tab */
        $this->start_controls_section(
            'point_style_section', [
                'label' => esc_html__('Time Point', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'point_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'stacked',
                'label_block' => false,
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'framed' => esc_html__('Framed', 'easy-elementor-addons'),
                    'stacked' => esc_html__('Stacked', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'point_background_toggle',
            [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'easy-elementor-addons'),
                'label_on' => esc_html__('Custom', 'easy-elementor-addons'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'point_style' => 'stacked',
                ],
            ]
        );

        $this->start_popover();

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'point_background',
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'color' => [
                    'default' => '#3858f4',
                ],
                'condition' => [
                    'point_background_toggle' => 'yes',
                    'point_style' => 'stacked',
                ],
                'selector' => '{{WRAPPER}} .eead-htl-point > span',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'point_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point .eead-htl-point-text, {{WRAPPER}} .eead-htl-point i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-htl-point svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .eead-htl-point-framed .eead-htl-point > span' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'point_style!' => 'stacked',
                ],
            ]
        );

        $this->add_control(
            'stacked_point_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point .eead-htl-point-text, {{WRAPPER}} .eead-htl-point i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-htl-point svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .eead-htl-point-framed .eead-htl-point > span' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'point_style' => 'stacked',
                ],
            ]
        );

        $this->add_responsive_control(
            'point_size', [
                'label' => esc_html__('Point Background Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 60,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point > span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-point-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'point_style!' => 'default',
                ],
            ]
        );

        $this->add_responsive_control(
            'point_icon_size', [
                'label' => esc_html__('Text/Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 21,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 250,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point > span' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-htl-point svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-point-icon-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'point_gap', [
                'label' => esc_html__('Point Gap', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-htl-point-pos-left .eead-htl-point:after' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-htl-point-pos-right .eead-htl-point:before' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'point_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point > span' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-point-border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'point_style' => 'framed',
                ]
            ]
        );

        $this->add_responsive_control(
            'point_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'point_style!' => 'default',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'point_typography',
                'label' => esc_html__('Point Text Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-htl-point > span.eead-htl-point-text',
                'exclude' => ['font_size', 'line_height']
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
            'timeline_height', [
                'label' => esc_html__('Line Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point:before, {{WRAPPER}} .eead-htl-point:after' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-timeline-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'timeline_color', [
                'label' => esc_html__('Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point:before, {{WRAPPER}} .eead-htl-point:after' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-timeline-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'timeline_spacing',
            [
                'label' => esc_html__('Top & Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-point' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-timeline-top-spacing: {{TOP}}{{UNIT}};--eead-htl-timeline-bottom-spacing: {{BOTTOM}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}} .eead-htl-meta span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'meta_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-meta span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'meta_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-htl-meta span'
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
                'selector' => '{{WRAPPER}} .eead-htl-meta span'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'meta_box_shadow',
                'selector' => '{{WRAPPER}} .eead-htl-meta span'
            ]
        );

        $this->add_responsive_control(
            'meta_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-meta span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'meta_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-meta span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-content-inner' => 'background-color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .eead-htl-content-inner'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .eead-htl-content-inner'
            ]
        );

        $this->add_responsive_control(
            'content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-htl-content .eead-htl-title'
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-description' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_desc_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-htl-content .eead-htl-description'
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
                    '{{WRAPPER}} .eead-htl-content .eead-htl-description' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
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
                'selector' => '{{WRAPPER}} .eead-htl-more-button a',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'readmore_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-more-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-more-button' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
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
                'selector' => '{{WRAPPER}} .eead-htl-more-button a',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'readmore_box_shadow',
                'selector' => '{{WRAPPER}} .eead-htl-more-button a'
            ]
        );

        $this->add_responsive_control(
            'readmore_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-more-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-htl-more-button a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_normal', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-more-button a' => 'background: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-htl-more-button a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-more-button a:hover' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'readmore_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-htl-more-button a:hover' => 'border: 1px solid {{VALUE}}',
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
                    'display_option' => 'carousel',
                    'arrows' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_on_hover', [
                'label' => esc_html__('Show on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
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
                    'size' => 50,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button' => 'width: {{SIZE}}{{UNIT}};'
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
                    'size' => 50,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-horizontal-timeline' => '--eead-htl-nav-offset-x:{{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button'
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-horizontal-timeline .owl-nav button:hover' => 'border-color: {{VALUE}}',
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
            'scrollbar_style', [
                'label' => esc_html__('Scrollbar', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_option' => 'scrollbar',
                ]
            ]
        );

        $this->add_control(
            'scrollbar_rail_color', [
                'label' => esc_html__('Rail Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mCS-dark.mCSB_scrollTools .mCSB_draggerRail' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'scrollbar_dragger_color', [
                'label' => esc_html__('Dragger Bar Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'scrollbar_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 50,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .mCSB_horizontal.mCSB_inside>.mCSB_container' => 'margin-bottom:{{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('timeline-container', [
            'class' => [
                'eead-htl-list',
                'eead-htl-' . esc_attr($settings['display_option']),
                'eead-htl-point-' . esc_attr($settings['point_style']),
                'eead-htl-meta-pos-' . esc_attr($settings['meta_position'])
            ]
        ]);

        if ($settings['display_option'] == 'carousel') {
            $params = array(
                'items' => $settings['slides_to_show']['size'] ? (int) $settings['slides_to_show']['size'] : 3,
                'items_tablet' => isset($settings['slides_to_show_tablet']['size']) ? (int) $settings['slides_to_show_tablet']['size'] : 2,
                'items_mobile' => isset($settings['slides_to_show_mobile']['size']) ? (int) $settings['slides_to_show_mobile']['size'] : 1,
                'autoplay' => $settings['autoplay'] && $settings['autoplay'] == 'yes' ? true : false,
                'loop' => $settings['infinite'] && $settings['infinite'] == 'yes' ? true : false,
                'pause' => isset($settings['autoplay_speed']['size']) ? (int) $settings['autoplay_speed']['size'] * 1000 : 500,
                'arrows' => $settings['arrows'] == 'yes' ? true : false,
                'pause_on_hover' => $settings['pause_on_hover'] == 'yes' ? true : false,
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

            $arrow_class = $settings['show_on_hover'] == 'yes' ? 'hide' : 'show';

            $this->add_render_attribute('timeline-container', [
                'class' => [
                    'owl-carousel',
                    'eead-htl-arrow-' . $arrow_class
                ],
                'data-params' => $params
            ]);
        }
        ?>

        <div class="eead-horizontal-timeline">
            <div <?php $this->print_render_attribute_string('timeline-container'); ?>>
                <?php
                $i = 0;
                foreach ($settings['item_list'] as $key => $item) {
                    if ($item['enable'] != 'yes') {
                        continue;
                    }
                    $alt_class = $i % 2 == 0 ? 'eead-htl-alt' : '';
                    ?>
                    <div class="eead-htl-card <?php echo esc_attr($alt_class); ?>">
                        <div class="eead-htl-content">
                            <div class="eead-htl-content-inner">
                                <?php if (!empty($item['image']['url'])) { ?>
                                    <div class="eead-htl-image">
                                        <?php
                                        echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($item, 'item_image', 'image'));
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($item['title'])) { ?>
                                    <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])); ?> class="eead-htl-title">
                                        <?php
                                        echo esc_html($item['title']);
                                        ?>
                                    </<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])); ?>>
                                <?php } ?>

                                <?php if (!empty($item['description'])) { ?>
                                    <div class="eead-htl-description">
                                        <?php echo esc_html($item['description']); ?>
                                    </div>
                                <?php } ?>

                                <?php
                                if (!empty($item['button_url']['url'])) {
                                    $this->add_link_attributes('button_url' . $i, $item['button_url']);
                                    ?>
                                    <div class="eead-htl-more-button">
                                        <a <?php $this->print_render_attribute_string('button_url' . $i); ?>>
                                            <?php echo esc_html($item['button_text']); ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="eead-htl-point">
                            <?php
                            if ($item['point_type'] == 'icon') {
                                ?>
                                <span class="eead-htl-point-icon">
                                    <?php Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                                <?php
                            } elseif ($item['point_type'] == 'text') {
                                ?>
                                <span class="eead-htl-point-text">
                                    <?php echo esc_html($item['point_text']); ?>
                                </span>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="eead-htl-meta">
                            <span><?php echo esc_html($item['meta']); ?></span>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>
        <?php
    }

}
