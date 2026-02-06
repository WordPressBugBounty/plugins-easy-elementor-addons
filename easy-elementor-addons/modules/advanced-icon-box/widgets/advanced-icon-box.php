<?php

namespace EasyElementorAddons\Modules\AdvancedIconBox\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Icon Widget
 */
class AdvancedIconBox extends Widget_Base {

    public function get_name() {
        return 'eead-advanced-icon-box';
    }

    public function get_title() {
        return esc_html__('Advanced Icon Box', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-icon-text';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content_icon_box', [
                'label' => esc_html__('Icon Box', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'icon_type', [
                'label' => esc_html__('Icon Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'icon',
                'prefix_class' => 'eead-aib-icon-type-',
                'render_type' => 'template',
                'options' => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star'
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image'
                    ]
                ]
            ]
        );

        $this->add_control(
            'selected_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ],
                'render_type' => 'template',
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Image Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'render_type' => 'template',
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_type' => 'image'
                ]
            ]
        );

        $this->add_control(
            'title_text', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Icon Box Heading', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Enter your title', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'description_text', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'placeholder' => esc_html__('Enter your description', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'show_separator', [
                'label' => esc_html__('Title Separator', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'title_separator_type', [
                'label' => esc_html__('Separator Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'line',
                'options' => [
                    'line' => esc_html__('Line', 'easy-elementor-addons'),
                    'line-circle' => esc_html__('Line Circle', 'easy-elementor-addons'),
                    'line-cross' => esc_html__('Line Cross', 'easy-elementor-addons'),
                    'line-star' => esc_html__('Line Star', 'easy-elementor-addons'),
                    'line-dashed' => esc_html__('Line Dashed', 'easy-elementor-addons'),
                    'heart' => esc_html__('Heart', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons'),
                    'floret' => esc_html__('Floret', 'easy-elementor-addons'),
                    'rectangle' => esc_html__('Rectangle', 'easy-elementor-addons'),
                    'leaf' => esc_html__('Leaf', 'easy-elementor-addons'),
                    'slash' => esc_html__('Slash', 'easy-elementor-addons'),
                    'triangle' => esc_html__('Triangle', 'easy-elementor-addons'),
                    'wave' => esc_html__('Wave', 'easy-elementor-addons'),
                    'kiss-curl' => esc_html__('Kiss Curl', 'easy-elementor-addons'),
                    'zemik' => esc_html__('Zemik', 'easy-elementor-addons'),
                    'finest' => esc_html__('Finest', 'easy-elementor-addons'),
                    'furrow' => esc_html__('Furrow', 'easy-elementor-addons'),
                    'peak' => esc_html__('Peak', 'easy-elementor-addons'),
                    'melody' => esc_html__('Melody', 'easy-elementor-addons'),
                    'jemik' => esc_html__('Jemik', 'easy-elementor-addons'),
                    'separk' => esc_html__('Separk', 'easy-elementor-addons'),
                    'zigzag-dot' => esc_html__('Zigzag Dot', 'easy-elementor-addons'),
                    'zozobe' => esc_html__('Zozobe', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'show_separator' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_inline', [
                'label' => esc_html__('Icon Inline', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
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
                'toggle' => false,
                'condition' => [
                    'icon_inline' => '',
                ],
                'selectors_dictionary' => [
                    'top' => '--eead-aib-display:block;--eead-aib-margin-bottom:var(--eead-aib-icon-spacing, 20px);',
                    'left' => '--eead-aib-display:flex;--eead-aib-flex-flow:row;--eead-aib-text-align:left;--eead-aib-margin-bottom:0;',
                    'right' => '--eead-aib-display:flex;--eead-aib-flex-flow:row-reverse;--eead-aib-text-align:right;--eead-aib-margin-bottom:0;'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '{{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'text_align', [
                'label' => esc_html__('Content Alignment', 'easy-elementor-addons'),
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
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-text-align: {{VALUE}};',
                ],
                'condition' => [
                    'icon_position' => 'top',
                ]
            ]
        );

        $this->add_responsive_control(
            'inline_text_align', [
                'label' => esc_html__('Content Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'left',
                'selectors_dictionary' => [
                    'left' => '--eead-aib-inline-flex-flow:row;--eead-aib-text-align:left;',
                    'right' => '--eead-aib-inline-flex-flow:row-reverse;--eead-aib-text-align:right;'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '{{VALUE}}',
                ],
                'condition' => [
                    'icon_inline' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'readmore', [
                'label' => esc_html__('Read More Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_readmore', [
                'label' => esc_html__('Read More', 'easy-elementor-addons'),
                'condition' => [
                    'readmore' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'readmore_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Read More', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'readmore_link', [
                'label' => esc_html__('Link to', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'readmore' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'advanced_readmore_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'readmore' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'readmore_icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => esc_html__('Left', 'easy-elementor-addons'),
                    'row' => esc_html__('Right', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'advanced_readmore_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button' => 'flex-flow: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'readmore_icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 8,
                ],
                'condition' => [
                    'advanced_readmore_icon[value]!' => '',
                    'readmore_text!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'condition' => [
                    'badge' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'badge_text', [
                'label' => esc_html__('Badge Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('New', 'easy-elementor-addons'),
                'placeholder' => 'Badge Title'
            ]
        );

        $this->add_control(
            'badge_position', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top-right',
                'options' => [
                    'top-left' => esc_html__('Top Left', 'easy-elementor-addons'),
                    'top-right' => esc_html__('Top Right', 'easy-elementor-addons'),
                    'bottom-left' => esc_html__('Bottom Left', 'easy-elementor-addons'),
                    'bottom-right' => esc_html__('Bottom Right', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_horizontal_offset', [
                'label' => esc_html__('Horizontal Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => -300,
                        'step' => 1,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-badge-h-offset: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_vertical_offset', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => -300,
                        'step' => 1,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-badge-v-offset: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'badge_rotate', [
                'label' => esc_html__('Rotate', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-badge-rotate: {{SIZE}}deg;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_additional', [
                'label' => esc_html__('Additional Options', 'easy-elementor-addons')
            ]
        );



        $this->add_control(
            'title_size', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => eead_html_tags(),
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_style_icon_box', [
                'label' => esc_html__('Icon/Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_space', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-icon-spacing: {{SIZE}}{{UNIT}};',
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
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_box_padding', [
                'label' => esc_html__('Icon Box Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_width', [
                'label' => esc_html__('Image Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 100,
                    'unit' => '%'
                ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'image',
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
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span'
            ]
        );

        $this->add_control(
            'icon_radius_advanced_show', [
                'label' => esc_html__('Advanced Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'icon_radius', [
                'label' => esc_html__('Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_radius_advanced_show!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'icon_radius_advanced', [
                'label' => esc_html__('Radius', 'easy-elementor-addons'),
                /* translators: 1: border radius, 2: link. */
                'description' => sprintf(__('For example: <b>%1$s</b> or Go <a href="%2$s" target="_blank">this link</a> and copy and paste the radius value.', 'easy-elementor-addons'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
                'type' => Controls_Manager::TEXT,
                'size_units' => ['px', '%'],
                'default' => '75% 25% 43% 57% / 46% 29% 71% 54%',
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'border-radius: {{VALUE}};'
                ],
                'condition' => [
                    'icon_radius_advanced_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'rotate', [
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
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-icon-rotate:{{SIZE}}deg;',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_vertical_offset', [
                'label' => esc_html__('Icon Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-icon-v-offset:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_horizontal_offset', [
                'label' => esc_html__('Icon Horizontal Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => '--eead-aib-icon-h-offset:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_overflow', [
                'label' => esc_html__('Overflow', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'visible',
                'options' => [
                    'visible' => esc_html__('Show', 'easy-elementor-addons'),
                    'hidden' => esc_html__('Hidden', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span' => 'overflow:{{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('icon_colors');

        $this->start_controls_tab(
            'icon_colors_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'icon_background',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span',
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'icon_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-icon span'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'icon_hover_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'icon_type!' => 'image',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'icon_hover_background',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-icon span',
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'icon_hover_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-icon span' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'icon_hover_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-icon span'
            ]
        );

        $this->add_control(
            'icon_hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-title'
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_style_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_style_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'section_style_description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-desc'
            ]
        );

        $this->add_responsive_control(
            'description_bottom_space', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_description_style');

        $this->start_controls_tab(
            'tab_description_style_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-desc' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_description_style_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'description_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box:hover .eead-aib-desc' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_title_separator', [
                'label' => esc_html__('Title Separator', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_separator' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'title_separator_border_style', [
                'label' => esc_html__('Separator Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => esc_html__('Solid', 'easy-elementor-addons'),
                    'dotted' => esc_html__('Dotted', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons'),
                    'groove' => esc_html__('Groove', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'title_separator_type' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-line-separator span' => 'border-bottom-style: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_separator_line_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'title_separator_type' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-line-separator span' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_separator_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 15,
                    ]
                ],
                'condition' => [
                    'title_separator_type' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-line-separator span' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'title_separator_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 300,
                    ]
                ],
                'condition' => [
                    'title_separator_type' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-line-separator span' => 'max-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'title_separator_svg_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'title_separator_type!' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-svg-separator svg' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'divider_svg_max_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'size_units' => ['px', 'em', '%'],
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                        'min' => 50,
                    ]
                ],
                'condition' => [
                    'title_separator_type!' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-svg-separator span' => 'max-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'divider_svg_max_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                        'min' => 1,
                    ]
                ],
                'condition' => [
                    'title_separator_type!' => 'line'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-svg-separator span' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'divider_svg_stroke_width', [
                'label' => esc_html__('Stroke Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                        'min' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-svg-separator svg *' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title_separator_type!' => 'line'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_separator_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-line-separator, {{WRAPPER}} .eead-advanced-icon-box .eead-aib-svg-separator' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_readmore', [
                'label' => esc_html__('Read More', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'readmore' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'readmore_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button'
            ]
        );

        $this->add_responsive_control(
            'readmore_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'readmore_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_readmore_style');

        $this->start_controls_tab(
            'tab_readmore_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'readmore_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'readmore_background',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button',
                'exclude' => ['image']
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
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'readmore_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_readmore_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'readmore_hover_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button:hover svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'readmore_hover_background',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button:hover',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'readmore_hover_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'readmore_hover_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-button:hover'
            ]
        );

        $this->add_control(
            'readmore_hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'badge' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge'
            ]
        );

        $this->add_control(
            'badge_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'badge_background',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge',
                'exclude' => ['image']
            ]
        );

        $this->add_responsive_control(
            'badge_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'badge_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'badge_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-icon-box .eead-aib-badge'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_additional', [
                'label' => esc_html__('Additional', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'outer_box_padding', [
                'label' => esc_html__('Content Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render_icon() {
        $settings = $this->get_settings_for_display();

        $has_icon = !empty($settings['selected_icon']['value']);
        $has_image = !empty($settings['image']['url']);

        if ($has_icon && ('icon' == $settings['icon_type'])) {
            $this->add_render_attribute('font-icon', [
                'class' => $settings['selected_icon'],
                'aria-hidden' => 'true'
            ]);
        } elseif ($has_image && ('image' == $settings['icon_type'])) {
            $this->add_render_attribute('image-icon', [
                'src' => esc_url($settings['image']['url']),
                'alt' => esc_html($settings['title_text'])
            ]);
        }

        $this->add_render_attribute('icon-class', 'class', 'eead-aib-icon');

        if ($settings['icon_hover_animation']) {
            $this->add_render_attribute('icon-class', 'class', 'elementor-animation-' . $settings['icon_hover_animation']);
        }

        if ($has_icon || $has_image) {
            ?>
            <div <?php $this->print_render_attribute_string('icon-class'); ?>>
                <span>
                    <?php
                    if ($has_icon && 'icon' == $settings['icon_type']) {
                        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                    } elseif ($has_image && 'image' == $settings['icon_type']) {
                        ?>
                        <img <?php $this->print_render_attribute_string('image-icon'); ?>>
                        <?php
                    }
                    ?>
                </span>
            </div>
            <?php
        }
    }

    protected function render_heading() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('advanced-icon-box-icon-heading', 'class', 'eead-aib-header');

        if ('yes' == $settings['icon_inline']) {
            $this->add_render_attribute('advanced-icon-box-icon-heading', 'class', 'eead-aib-inline-icon');
        }
        ?>
        <div <?php $this->print_render_attribute_string('advanced-icon-box-icon-heading'); ?>>
            <?php
            if ('yes' == $settings['icon_inline']) {
                $this->render_icon();
            }

            if ($settings['title_text']) {
                ?>
                <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_size'])); ?> class="eead-aib-title">
                    <span>
                        <?php echo wp_kses($settings['title_text'], eead_allow_tags('title')); ?>
                    </span>
                </<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_size'])); ?>>
                <?php
            }
            ?>
        </div>
        <?php
    }

    protected function valid_svg_list() {
        return array(
            'line',
            'line-circle',
            'line-cross',
            'line-star',
            'line-dashed',
            'heart',
            'dashed',
            'floret',
            'rectangle',
            'leaf',
            'slash',
            'triangle',
            'wave',
            'kiss-curl',
            'zemik',
            'finest',
            'furrow',
            'peak',
            'melody',
            'jemik',
            'separk',
            'zigzag-dot',
            'zozobe'
        );
    }

    public function render_svg_image() {
        $settings = $this->get_settings_for_display();

        $align = $settings['text_align'] ? $settings['text_align'] : $settings['icon_position'];
        $title_separator_type = in_array($settings['title_separator_type'], $this->valid_svg_list()) ? $settings['title_separator_type'] : 'line';
        $svg_image = EEAD_PATH . 'assets/img/divider/' . esc_attr($title_separator_type) . '-' . $align . '.svg';

        if (file_exists($svg_image)) {
            $file_path = $svg_image;
        } else {
            $file_path = EEAD_PATH . 'assets/img/divider/' . esc_attr($title_separator_type) . '.svg';
        }

        include($file_path);
    }

    protected function render_button() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('readmore', 'class', ['eead-aib-button']);

        if (!empty($settings['readmore_link']['url'])) {
            $this->add_render_attribute('readmore', 'href', $settings['readmore_link']['url']);

            if ($settings['readmore_link']['is_external']) {
                $this->add_render_attribute('readmore', 'target', '_blank');
            }

            if ($settings['readmore_link']['nofollow']) {
                $this->add_render_attribute('readmore', 'rel', 'nofollow');
            }
        }

        if ($settings['readmore_hover_animation']) {
            $this->add_render_attribute('readmore', 'class', 'elementor-animation-' . $settings['readmore_hover_animation']);
        }

        if ($settings['readmore']) {
            ?>
            <a <?php $this->print_render_attribute_string('readmore'); ?>>
                <?php
                echo esc_html($settings['readmore_text']);
                Icons_Manager::render_icon($settings['advanced_readmore_icon'], ['aria-hidden' => 'true']);
                ?>
            </a>
            <?php
        }
    }

    protected function render_badge() {
        $settings = $this->get_settings_for_display();

        if ($settings['badge'] && ('' != $settings['badge_text'])) {
            ?>
            <div class="eead-aib-badge eead-aib-pos-<?php echo esc_attr($settings['badge_position']); ?>">
                <span>
                    <?php echo esc_html($settings['badge_text']); ?>
                </span>
            </div>
            <?php
        }
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('description_text', 'class', 'eead-advanced-icon-box-description');
        $this->add_inline_editing_attributes('title_text', 'none');
        ?>
        <div class="eead-advanced-icon-box">
            <?php
            if ('yes' !== $settings['icon_inline']) {
                $this->render_icon();
            }
            ?>

            <div class="eead-aib-content">
                <?php
                $this->render_heading();
                if ($settings['show_separator']) {
                    if ('line' == $settings['title_separator_type']) {
                        ?>
                        <div class="eead-aib-line-separator">
                            <span></span>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="eead-aib-svg-separator">
                            <span>
                                <?php $this->render_svg_image(); ?>
                            </span>
                        </div>
                        <?php
                    }
                }

                if ($settings['description_text']) {
                    ?>
                    <div class="eead-aib-desc">
                        <?php echo wp_kses_post($this->parse_text_editor($settings['description_text'])); ?>
                    </div>
                    <?php
                }

                $this->render_button();
                ?>
            </div>

            <?php $this->render_badge(); ?>
        </div>
        <?php
    }

}
