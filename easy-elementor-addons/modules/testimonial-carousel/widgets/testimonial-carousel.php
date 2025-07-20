<?php

namespace EasyElementorAddons\Modules\TestimonialCarousel\Widgets;

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

class TestimonialCarousel extends Widget_Base {

    public function get_name() {
        return 'eead-testimonial-carousel';
    }

    public function get_title() {
        return esc_html__('Testimonial Carousel', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-testimonial-carousel';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['owlcarousel'];
    }

    public function get_script_depends() {
        return ['owlcarousel'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_testimonials', [
                'label' => esc_html__('Testimonials', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Add Testimonials', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ],
                    [
                        'name' => 'name',
                        'label' => esc_html__('Name', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => 'John Doe'
                    ],
                    [
                        'name' => 'designation',
                        'label' => esc_html__('Designation', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => 'Support Engineer'
                    ],
                    [
                        'name' => 'testimonial_title',
                        'label' => esc_html__('Testimonial Title', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => ''
                    ],
                    [
                        'name' => 'testimonial_content',
                        'label' => esc_html__('Testimonial', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXTAREA,
                        'rows' => 8,
                        'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
                    ],
                    [
                        'name' => 'show_rating',
                        'label' => esc_html__('Show Rating', 'easy-elementor-addons'),
                        'type' => Controls_Manager::SWITCHER,
                        'separator' => 'before'
                    ],
                    [
                        'name' => 'rating',
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
                ],
                'title_field' => '{{{ name }}}',
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

        $this->add_control(
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
                'name' => 'thumbnail',
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
            'carousel_settings', [
                'label' => esc_html__('Carousel Settings', 'easy-elementor-addons')
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

        $this->add_responsive_control(
            'slides_margin', [
                'label' => esc_html__('Spacing Between Slides', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ]
            ]
        );

        $this->add_responsive_control(
            'slides_stagepadding', [
                'label' => esc_html__('Stage Padding', 'easy-elementor-addons'),
                'description' => esc_html__('Space or padding between the carousel stage and the edge of the container', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 0,
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
            'auto_height', [
                'label' => esc_html__('Auto Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'dots', [
                'label' => esc_html__('Navigation Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'arrows', [
                'label' => esc_html__('Navigation Arrows', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'focus_center_slide', [
                'label' => esc_html__('Focus Center', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'shrink_side_slides', [
                'label' => esc_html__('Shrink Side Slides', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '0.8'
                ],
                'range' => [
                    'px' => [
                        'min' => 0.6,
                        'max' => 0.95,
                        'step' => .05
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-item:not(.center)' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
                ],
                'condition' => [
                    'focus_center_slide' => 'yes'
                ]
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

        $this->add_control(
            'container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'container_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
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
                    '{{WRAPPER}} .eead-testimonial-content .eead-testimonial-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'testimonial_title_color_hover', [
                'label' => esc_html__('Color (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-content:hover .eead-testimonial-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'testimonial_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-testimonial-content .eead-testimonial-title'
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
                    '{{WRAPPER}} .eead-testimonial-content .eead-testimonial-txt' => 'color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .eead-testimonial-content .eead-testimonial-txt'
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

        $this->end_controls_section();

        $this->start_controls_section(
            'dot_style', [
                'label' => esc_html__('Navigation Dot', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots span' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots span' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_spacing', [
                'label' => esc_html__('Spacing Between Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_upper_spacing', [
                'label' => esc_html__('Spacing Above Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'dots_border',
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
                'selector' => '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot span'
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'dot_tabs'
        );

        $this->start_controls_tab(
            'dot_style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'dot_style_active_tab', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color_active', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_scale_active', [
                'label' => esc_html__('Scale Dots', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '1.3'
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => .05
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot.active span' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'dot_style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dot_bg_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}}',
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
                    'arrows' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_on_hover', [
                'label' => esc_html__('Show on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
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
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button' => 'width: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-testimonial-carousel' => '--eead-testimonial-carousel-offset-x:{{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'arrow_translate_y', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-testimonial-carousel' => '--eead-testimonial-carousel-offset-y:{{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button'
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-testimonial-carousel .owl-nav button:hover' => 'border-color: {{VALUE}}',
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
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $testimonials = $settings['testimonials'];

        $params = array(
            'items' => $settings['slides_to_show']['size'] ? (int) $settings['slides_to_show']['size'] : 3,
            'items_tablet' => isset($settings['slides_to_show_tablet']['size']) ? (int) $settings['slides_to_show_tablet']['size'] : 2,
            'items_mobile' => isset($settings['slides_to_show_mobile']['size']) ? (int) $settings['slides_to_show_mobile']['size'] : 1,
            'margin' => isset($settings['slides_margin']['size']) && $settings['slides_margin']['size'] !== null ? (int) $settings['slides_margin']['size'] : 20,
            'margin_tablet' => isset($settings['slides_margin_tablet']['size']) && $settings['slides_margin_tablet']['size'] !== null ? (int) $settings['slides_margin_tablet']['size'] : 20,
            'margin_mobile' => isset($settings['slides_margin_mobile']['size']) && $settings['slides_margin_mobile']['size'] !== null ? (int) $settings['slides_margin_mobile']['size'] : 20,
            'autoplay' => $settings['autoplay'] && $settings['autoplay'] == 'yes' ? true : false,
            'loop' => $settings['infinite'] && $settings['infinite'] == 'yes' ? true : false,
            'pause' => isset($settings['autoplay_speed']['size']) ? (int) $settings['autoplay_speed']['size'] * 1000 : 500,
            'dots' => $settings['dots'] == 'yes' ? true : false,
            'arrows' => $settings['arrows'] == 'yes' ? true : false,
            'pause_on_hover' => $settings['pause_on_hover'] == 'yes' ? true : false,
            'auto_height' => $settings['auto_height'] == 'yes' ? true : false,
            'stagepadding' => $settings['slides_stagepadding']['size'] && $settings['slides_stagepadding']['size'] !== null ? (int) $settings['slides_stagepadding']['size'] : 0,
            'stagepadding_tablet' => isset($settings['slides_stagepadding_tablet']['size']) && $settings['slides_stagepadding_tablet']['size'] !== null ? (int) $settings['slides_stagepadding_tablet']['size'] : 0,
            'stagepadding_mobile' => isset($settings['slides_stagepadding_mobile']['size']) && $settings['slides_stagepadding_mobile']['size'] !== null ? (int) $settings['slides_stagepadding_mobile']['size'] : 0,
            'focus_center_slide' => $settings['focus_center_slide'] == 'yes' ? true : false,
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

        $this->add_render_attribute('testimonial-wrapper', [
            'class' => [
                'eead-testimonial-carousel',
                'owl-carousel',
                'eead-tc-hover-arrow-' . ($settings['show_on_hover'] ? 'on' : 'off'),
            ],
            'data-params' => $params
        ]);
        ?>
        <div <?php $this->print_render_attribute_string('testimonial-wrapper'); ?>>
            <?php
            if (!empty($testimonials)) {
                foreach ($testimonials as $index => $testimonial) {
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
                            $this->render_thumb($testimonial);
                            $this->render_name($testimonial);
                            $this->render_designation($testimonial);
                            $this->render_rating($testimonial);
                            echo '</div>';
                            $this->render_testimony($testimonial);
                        } else if ($settings['layout'] == 'style2') {
                            echo '<div class="eead-testimonial-header">';
                            $this->render_thumb($testimonial);
                            echo '<div class="eead-testimonial-user">';
                            $this->render_name($testimonial);
                            $this->render_designation($testimonial);
                            $this->render_rating($testimonial);
                            echo '</div>';
                            echo '</div>';
                            $this->render_testimony($testimonial);
                        } else if ($settings['layout'] == 'style3') {
                            $this->render_thumb($testimonial);
                            echo '<div class="eead-testimonial-details">';
                            $this->render_testimony($testimonial);
                            $this->render_name($testimonial);
                            $this->render_designation($testimonial);
                            $this->render_rating($testimonial);
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }

    protected function render_rating($item) {
        $stars = '';
        if ($item['show_rating'] == 'yes') {
            $rating_count = isset($item['rating']['size']) ? $item['rating']['size'] : 5;
            ?>
            <div class="eead-testimonial-rating">
                <?php
                for ($i = 0; $i < $rating_count; $i++) {
                    $stars .= '<i class="icofont-star"></i>';
                }
                echo $stars;
                ?>
            </div>
            <?php
        }
    }

    protected function render_thumb($item) {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-testimonial-image">
            <?php
            $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'thumbnail', $settings);
            if ($image_url) {
                echo '<img src="' . esc_url($image_url) . '">';
            } else {
                echo '<img src="' . esc_url($item['image']['url']) . '">';
            }
            ?>
        </div>
        <?php
    }

    protected function render_testimony($item) {
        ?>
        <div class="eead-testimonial-content">
            <?php
            if (!empty($settings['testimonial_title'])) {
                printf('<h4 class="eead-testimonial-title">%1$s</h4>', esc_html($item['testimonial_title']));
            }

            if (!empty($item['testimonial_content'])) {
                echo '<div class="eead-testimonial-txt">';
                echo wp_kses_post($item['testimonial_content']);
                echo '</div>';
            }
            ?>
        </div>
        <?php
    }

    protected function render_name($item) {
        ?>
        <h4 class="eead-testimonial-name">
            <?php echo esc_html($item['name']); ?>
        </h4>
        <?php
    }

    protected function render_designation($item) {
        ?>
        <div class="eead-testimonial-designation">
            <?php echo esc_html($item['designation']); ?>
        </div>
        <?php
    }

}
