<?php

namespace EasyElementorAddons\Modules\Testimonial\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Testimonial extends Widget_Base {

    public function get_name() {
        return 'eead-testimonial';
    }

    public function get_title() {
        return esc_html__('Testimonial', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-testimonial';
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

        $this->add_control(
            'image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'name', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'John Doe'
            ]
        );

        $this->add_control(
            'designation', [
                'label' => esc_html__('Designation', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Support Engineer'
            ]
        );

        $this->add_control(
            'testimonial_title', [
                'label' => esc_html__('Testimonial Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => ''
            ]
        );

        $this->add_control(
            'testimonial_content', [
                'label' => esc_html__('Testimonial', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 8,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
            ]
        );

        $this->add_control(
            'show_rating', [
                'label' => esc_html__('Show Rating', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'rating', [
                'label' => esc_html__('Rating', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 5,
                    'unit' => 's',
                ],
                'condition' => [
                    'show_rating' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'quote_settings', [
                'label' => esc_html__('Quote Icon', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'quote_icon', [
                'label' => esc_html__('Quote Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => array(
                    'value' => 'icofont-quote-right',
                    'library' => 'iconfont'
                )
            ]
        );

        $this->add_responsive_control(
            'quote_size', [
                'label' => esc_html__('Quote Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'size' => 28,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'font-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'quote_h_position', [
                'label' => esc_html__('Horizontal Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => 'right',
                'toggle' => false,
                'selectors_dictionary' => [
                    'center' => 'left:50%;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => '{{VALUE}};--eead-scroll-image-link-h:-50%;'
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_offset_left', [
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
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'left:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'quote_h_position' => 'left',
                ]
            ]
        );

        $this->add_responsive_control(
            'quote_offset_right', [
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
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'right:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'quote_h_position' => 'right',
                ]
            ]
        );

        $this->add_responsive_control(
            'quote_v_position', [
                'label' => esc_html__('Vertical Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => 'top',
                'toggle' => false,
                'selectors_dictionary' => [
                    'middle' => 'top:50%;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => '{{VALUE}};--eead-scroll-image-link-v:-50%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_offset_top', [
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
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'top:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'quote_v_position' => 'top',
                ]
            ]
        );

        $this->add_responsive_control(
            'quote_offset_bottom', [
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
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'bottom:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'quote_v_position' => 'bottom',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
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

        $this->add_control(
            'image_shape', [
                'label' => esc_html__('Image Shape', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'eead-round',
                'options' => [
                    'eead-square' => esc_html__('Square', 'easy-elementor-addons'),
                    'eead-round' => esc_html__('Round', 'easy-elementor-addons')
                ]
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
                ],
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'testimony_v_position', [
                'label' => esc_html__('Testimony Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'column-reverse',
                'options' => [
                    'column-reverse' => esc_html__('Top', 'easy-elementor-addons'),
                    'column' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'flex-direction:{{VALUE}}',
                ],
                'condition' => [
                    'layout' => ['style1', 'style2']
                ]
            ]
        );

        $this->add_control(
            'testimony_h_position', [
                'label' => esc_html__('Testimony Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__('Left', 'easy-elementor-addons'),
                    'row-reverse' => esc_html__('Right', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'flex-direction:{{VALUE}}',
                ],
                'condition' => [
                    'layout' => ['style3']
                ]
            ]
        );

        $this->add_responsive_control(
            'testimony_spacing', [
                'label' => esc_html__('Testimony Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'container_style', [
                'label' => esc_html__('Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs(
            'container_style_tabs'
        );

        $this->start_controls_tab(
            'container_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'container_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-testimonial-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'container_box_shadow',
                'label' => esc_html__('Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-container'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'container_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'container_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-testimonial-container:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'container_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-container:hover'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'text_alignment', [
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
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'layout' => ['style1']
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'container_border',
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
                'selector' => '{{WRAPPER}} .eead-testimonial-container'
            ]
        );

        $this->add_responsive_control(
            'container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'container_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'testimonial_image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width', [
                'label' => esc_html__('Image Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 600,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-image' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
                ],
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
                'selector' => '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-image'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-image',
            ]
        );

        $this->add_responsive_control(
            'image_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-image' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'layout' => ['style1']
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'name_style', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'name_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-name' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'name_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-name' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'name_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-name'
            ]
        );

        $this->add_responsive_control(
            'name_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-name' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'designation_style', [
                'label' => esc_html__('Designation', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'designation_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-designation' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'designation_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-designation' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'designation_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-designation'
            ]
        );

        $this->add_responsive_control(
            'designation_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-designation' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_rating' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'testimonial_style', [
                'label' => esc_html__('Testimony', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'testimonial_bg',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-testimonial-content',
                'condition' => [
                    'layout!' => 'style3'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'testimonial_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-content',
                'condition' => [
                    'layout!' => 'style3'
                ]
            ]
        );

        $this->add_responsive_control(
            'testimonial_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout!' => 'style3'
                ]
            ]
        );

        $this->add_responsive_control(
            'testimonial_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout!' => 'style3'
                ]
            ]
        );

        $this->start_controls_tabs(
            'testimony_style_tabs'
        );

        $this->start_controls_tab(
            'testimony_title_tab',
            [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'testimonial_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'testimonial_title_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'testimonial_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-title'
            ]
        );

        $this->add_responsive_control(
            'testimonial_title_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'testimony_content_tab',
            [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'testimonial_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-txt' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'testimonial_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-txt' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'testimonial_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-txt'
            ]
        );

        $this->add_responsive_control(
            'testimonial_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-txt' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'layout' => 'style3'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'rating_style', [
                'label' => esc_html__('Rating', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_rating' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'rating_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-rating' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'rating_size', [
                'label' => esc_html__('Star Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ]
                ],
                'default' => [
                    'size' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'testimonial_quote', [
                'label' => esc_html__('Quote', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'quote_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-testimonial-container .eead-testimonial-quote svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'quote_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-quote' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-testimonial-container:hover .eead-testimonial-quote svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="eead-testimonial-container <?php echo esc_attr($settings['image_shape']) . ' eead-testimonial-' . esc_attr($settings['layout']) ?>">
            <?php
            if (!empty($settings['quote_icon']['value'])) {
                echo '<div class="eead-testimonial-quote">';
                Icons_Manager::render_icon($settings['quote_icon'], ['aria-hidden' => 'true']);
                echo '</div>';
            }

            if ($settings['layout'] == 'style1') {
                echo '<div class="eead-testimonial-header">';
                $this->render_thumb();
                $this->render_name();
                $this->render_designation();
                $this->render_rating();
                echo '</div>';
                $this->render_testimony();
            } else if ($settings['layout'] == 'style2') {
                echo '<div class="eead-testimonial-header">';
                $this->render_thumb();
                echo '<div class="eead-testimonial-user">';
                $this->render_name();
                $this->render_designation();
                $this->render_rating();
                echo '</div>';
                echo '</div>';
                $this->render_testimony();
            } else if ($settings['layout'] == 'style3') {
                $this->render_thumb();
                echo '<div class="eead-testimonial-details">';
                $this->render_testimony();
                $this->render_name();
                $this->render_designation();
                $this->render_rating();
                echo '</div>';
            }
            ?>
        </div>
        <?php
    }

    protected function render_rating() {
        $settings = $this->get_settings_for_display();
        $stars = '';
        if ($settings['show_rating'] == 'yes') {
            $rating_count = isset($settings['rating']['size']) ? $settings['rating']['size'] : 5;
            ?>
            <div class="eead-testimonial-rating">
                <?php
                for ($i = 0; $i < $rating_count; $i++) {
                    $stars .= '<i class="icofont-star"></i>';
                }
                echo wp_kses_post($stars);
                ?>
            </div>
            <?php
        }
    }

    protected function render_thumb() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-testimonial-image">
            <?php echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings, 'thumb', 'image')); ?>
        </div>
        <?php
    }

    protected function render_testimony() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-testimonial-content">
            <?php
            if (!empty($settings['testimonial_title'])) {
                printf('<h4 class="eead-testimonial-title">%1$s</h4>', esc_html($settings['testimonial_title']));
            }

            if (!empty($settings['testimonial_content'])) {
                echo '<div class="eead-testimonial-txt">';
                echo wp_kses_post($settings['testimonial_content']);
                echo '</div>';
            }
            ?>
        </div>
        <?php
    }

    protected function render_name() {
        $settings = $this->get_settings_for_display();
        ?>
        <h4 class="eead-testimonial-name">
            <?php echo esc_html($settings['name']); ?>
        </h4>
        <?php
    }

    protected function render_designation() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-testimonial-designation">
            <?php echo esc_html($settings['designation']); ?>
        </div>
        <?php
    }

}
