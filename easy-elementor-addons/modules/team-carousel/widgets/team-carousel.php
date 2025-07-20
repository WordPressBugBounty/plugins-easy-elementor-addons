<?php

namespace EasyElementorAddons\Modules\TeamCarousel\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class TeamCarousel extends Widget_Base {

    public function get_name() {
        return 'eead-team-carousel';
    }

    public function get_title() {
        return esc_html__('Team Carousel', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-team-carousel';
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
            'section_team_members', [
                'label' => esc_html__('Team Members', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => esc_html__('Add Team Member', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => esc_html__('Image', 'easy-elementor-addons'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ],
                    [
                        'name' => 'name',
                        'label' => esc_html__('Name', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('John Doe', 'easy-elementor-addons')
                    ],
                    [
                        'name' => 'position',
                        'label' => esc_html__('Designation', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('WordPress Developer', 'easy-elementor-addons')
                    ],
                    [
                        'name' => 'description',
                        'label' => esc_html__('Description', 'easy-elementor-addons'),
                        'type' => Controls_Manager::TEXTAREA,
                    ],
                    [
                        'name' => 'link',
                        'label' => esc_html__('Link', 'easy-elementor-addons'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => 'https://www.your-link.com',
                    ],
                    [
                        'name' => 'hr1',
                        'type' => Controls_Manager::DIVIDER,
                    ],
                    [
                        'name' => 'social_icon_1',
                        'label' => esc_html__('Social Icon', 'easy-elementor-addons'),
                        'type' => Controls_Manager::ICONS,
                        'skin' => 'inline',
                        'label_block' => false,
                        'default' => array(
                            'value' => 'icofont-facebook',
                            'library' => 'iconfont'
                        ),
                    ],
                    [
                        'name' => 'social_link_1',
                        'label' => esc_html__('Social Link', 'easy-elementor-addons'),
                        'type' => Controls_Manager::URL,
                    ],
                    [
                        'name' => 'hr2',
                        'type' => Controls_Manager::DIVIDER,
                    ],
                    [
                        'name' => 'social_icon_2',
                        'label' => esc_html__('Social Icon', 'easy-elementor-addons'),
                        'type' => Controls_Manager::ICONS,
                        'skin' => 'inline',
                        'label_block' => false,
                        'default' => array(
                            'value' => 'icofont-x-twitter',
                            'library' => 'iconfont'
                        )
                    ],
                    [
                        'name' => 'social_link_2',
                        'label' => esc_html__('Social Link', 'easy-elementor-addons'),
                        'type' => Controls_Manager::URL,
                    ],
                    [
                        'name' => 'hr3',
                        'type' => Controls_Manager::DIVIDER,
                    ],
                    [
                        'name' => 'social_icon_3',
                        'label' => esc_html__('Social Icon', 'easy-elementor-addons'),
                        'type' => Controls_Manager::ICONS,
                        'skin' => 'inline',
                        'label_block' => false,
                        'default' => array(
                            'value' => 'icofont-instagram',
                            'library' => 'iconfont'
                        )
                    ],
                    [
                        'name' => 'social_link_3',
                        'label' => esc_html__('Social Link', 'easy-elementor-addons'),
                        'type' => Controls_Manager::URL,
                    ],
                    [
                        'name' => 'hr4',
                        'type' => Controls_Manager::DIVIDER,
                    ],
                    [
                        'name' => 'social_icon_4',
                        'label' => esc_html__('Social Icon', 'easy-elementor-addons'),
                        'type' => Controls_Manager::ICONS,
                        'skin' => 'inline',
                        'label_block' => false,
                        'default' => array(
                            'value' => 'icofont-whatsapp',
                            'library' => 'iconfont'
                        ),
                    ],
                    [
                        'name' => 'social_link_4',
                        'label' => esc_html__('Social Link', 'easy-elementor-addons'),
                        'type' => Controls_Manager::URL,
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail',
                'label' => esc_html__('Image Size', 'easy-elementor-addons'),
                'default' => 'full'
            ]
        );

        $this->add_control(
            'content_display', [
                'label' => esc_html__('Content Display', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'below-image',
                'options' => [
                    'below-image' => esc_html__('Below Image', 'easy-elementor-addons'),
                    'on-image-hover' => esc_html__('On Image Hover', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'social_icon_display', [
                'label' => esc_html__('Social Icons Display', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'below-content',
                'options' => [
                    'below-content' => esc_html__('Below Content', 'easy-elementor-addons'),
                    'on-image-hover' => esc_html__('On Image Hover', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'social_icon_position', [
                'label' => esc_html__('Social Icons Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom-center',
                'options' => [
                    'bottom-center' => esc_html__('Bottom Center', 'easy-elementor-addons'),
                    'top-left-vertical' => esc_html__('Top Left Vertical', 'easy-elementor-addons'),
                    'middle-left-vertical' => esc_html__('Middle Left Vertical', 'easy-elementor-addons'),
                    'bottom-left-vertical' => esc_html__('Bottom Left Vertical', 'easy-elementor-addons'),
                    'top-right-vertical' => esc_html__('Top Right Vertical', 'easy-elementor-addons'),
                    'middle-right-vertical' => esc_html__('Middle Right Vertical', 'easy-elementor-addons'),
                    'bottom-right-vertical' => esc_html__('Bottom Right Vertical', 'easy-elementor-addons')
                ],
                'condition' => [
                    'content_display' => 'below-image',
                    'social_icon_display' => 'on-image-hover'
                ]
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
                    '{{WRAPPER}} .eead-team-carousel .owl-item:not(.center)' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
                ],
                'condition' => [
                    'focus_center_slide' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /* All Styles */
        $this->start_controls_section(
            'section_container_style', [
                'label' => esc_html__('Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'container_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-team-member',
                'condition' => [
                    'content_display' => 'below-image'
                ]
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
                'selector' => '{{WRAPPER}} .eead-team-member'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .eead-team-member'
            ]
        );

        $this->add_responsive_control(
            'container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'container_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member, {{WRAPPER}} .eead-team-member.eead-content-on-image-hover .eead-team-member-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_text_alignment', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-team-member' => 'text-align:{{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'content_vertical_alignment', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-content-wrapper' => 'align-items: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'on-image-hover'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'content_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-team-member-content-wrapper',
                'condition' => [
                    'content_display' => 'on-image-hover'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'content_display' => 'on-image-hover'
                ]
            ]
        );

        $this->add_control(
            'content_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel' => '--eead-team-carousel-text-color: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'on-image-hover'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_member_image_style', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'custom_image_height', [
                'label' => esc_html__('Custom Image Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );

        $this->add_responsive_control(
            'image_height', [
                'label' => esc_html__('Image Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 180,
                    ],
                    'px' => [
                        'max' => 600,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-image' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'custom_image_height' => 'yes'
                ]
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
                    '{{WRAPPER}} .eead-team-member-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_control(
            'image_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                    '{{WRAPPER}} .eead-team-member-image' => 'align-self: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member.eead-content-below-image .eead-team-member-image, {{WRAPPER}} .eead-team-member.eead-content-on-image-hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
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
                'selector' => '{{WRAPPER}} .eead-team-member-image'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .eead-team-member-image',
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_bottom_margin', [
                'label' => esc_html__('Margin Bottom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_name_style', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'name_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-team-member-name'
            ]
        );

        $this->add_control(
            'name_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-name' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'name_margin', [
                'label' => esc_html__('Margin Bottom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_position_style', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'position_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-team-member-position'
            ]
        );

        $this->add_control(
            'position_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-position' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'position_margin', [
                'label' => esc_html__('Margin Bottom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_description_style', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'description!' => '',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-team-member-description',
            ]
        );

        $this->add_control(
            'description_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_display' => 'below-image'
                ]
            ]
        );

        $this->add_responsive_control(
            'description_margin', [
                'label' => esc_html__('Margin Bottom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_social_links_style', [
                'label' => esc_html__('Social Links', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'social_links_icons_gap', [
                'label' => esc_html__('Icons Gap', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'max' => 60,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'social_links_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 30,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'social_links_icon_padding', [
                'label' => esc_html__('Icon Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
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
                    '{{WRAPPER}} .eead-team-member-social-links a' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'social_links_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'social_links_box_shadow',
                'selector' => '{{WRAPPER}} .eead-team-member-social-links a'
            ]
        );

        $this->start_controls_tabs('tabs_links_style');

        $this->start_controls_tab(
            'tab_links_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'social_links_links_icons_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-team-member-social-links a svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'social_links_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'social_links_border_normal',
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
                'selector' => '{{WRAPPER}} .eead-team-member-social-links a'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'social_links_icons_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-team-member-social-links a:hover svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'social_links_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_links_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-member-social-links a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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

        $this->add_control(
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots span' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots span' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot span'
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot.active span' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});'
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
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dot_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button' => 'width: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button' => 'height: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-team-carousel' => '--eead-team-carousel-offset-x:{{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .eead-team-carousel' => '--eead-team-carousel-offset-y:{{SIZE}}{{UNIT}};'
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
                'selector' => '{{WRAPPER}} .eead-team-carousel .owl-nav button'
            ]
        );

        $this->add_responsive_control(
            'arrows_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-team-carousel .owl-nav button:hover' => 'border-color: {{VALUE}}',
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

    protected function get_image($item) {
        $settings = $this->get_settings();
        $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'thumbnail', $settings);
        if ($image_url) {
            $image_html = '<img src="' . esc_url($image_url) . '">';
        } else {
            $image_html = '<img src="' . esc_url($item['image']['url']) . '">';
        }

        if ($item['link']['url'] != '') {
            $image_html = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('link'), $image_html);
        }

        return $image_html;
    }

    protected function get_description($item) {
        if (!empty($item['description'])) {
            ?>
            <div class="eead-team-member-description">
                <?php echo parse_wisiwyg_content($item['description']); ?>
            </div>
            <?php
        }
    }

    protected function get_member_name($item) {
        $member_name = '';
        if ($item['name'] != '') {
            if ($item['link']['url'] != '') {
                $member_name .= sprintf('<%1$s %2$s><a %3$s>%4$s</a></%1$s>', 'h4', 'class="eead-team-member-name"', $this->get_render_attribute_string('link'), esc_html($item['name']));
            } else {
                $member_name .= sprintf('<%1$s %2$s>%3$s</%1$s>', 'h4', 'class="eead-team-member-name"', esc_html($item['name']));
            }
        }
        return $member_name;
    }

    protected function get_member_position($item) {
        $position = '';

        if ($item['position'] != '') {
            $position .= sprintf('<%1$s %2$s>%3$s</%1$s>', 'h5', 'class="eead-team-member-position"', esc_html($item['position']));
        }
        return $position;
    }

    protected function get_social_links($item, $index) {
        $social_html = '';
        ob_start();
        for ($i = 1; $i <= 4; $i++) {
            ?>
            <?php
            if (!empty($item['social_link_' . $i]['url']) && !empty($item['social_icon_' . $i])) {
                $this->add_link_attributes('social-link-' . $i . $index, $item['social_link_' . $i]);
                ?>
                <a <?php echo $this->get_render_attribute_string('social-link-' . $i . $index); ?>>
                    <?php Icons_Manager::render_icon($item['social_icon_' . $i], ['aria-hidden' => 'true']); ?>
                </a>
                <?php
            }
        }
        $social_html = ob_get_clean();

        if ($social_html != '') {
            echo '<div class="eead-team-member-social-links">';
            echo $social_html;
            echo '</div>';
        }
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $team_members = $settings['team_members'];
        $custom_height_class = $settings['custom_image_height'] == 'yes' ? 'eead-team-image-custom-height' : '';
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

        $this->add_render_attribute('team-wrapper', [
            'class' => [
                'eead-team-carousel',
                'owl-carousel',
                'eead-tc-hover-arrow-' . ($settings['show_on_hover'] ? 'on' : 'off'),
            ],
            'data-params' => $params
        ]);

        if ($settings['social_icon_display'] == 'on-image-hover') {
            $this->add_render_attribute('team', [
                'class' => [
                    'eead-social-' . esc_attr($settings['social_icon_display']),
                    'eead-social-pos-' . ($settings['social_icon_position'] ? esc_attr($settings['social_icon_position']) : 'bottom-center')
                ]
            ]);
        }

        $this->add_render_attribute('team', [
            'class' => [
                'eead-team-member',
                'eead-content-' . esc_attr($settings['content_display']),
                esc_attr($custom_height_class)
            ]
        ]);
        ?>
        <div <?php $this->print_render_attribute_string('team-wrapper'); ?>>
            <?php
            if (!empty($team_members)) {
                foreach ($team_members as $index => $team_member) {
                    ?>
                    <div <?php $this->print_render_attribute_string('team'); ?>>
                        <?php
                        if (!empty($team_member['image']['url'])) {
                            ?>
                            <div class="eead-team-member-image">
                                <?php
                                echo $this->get_image($team_member);

                                if ($settings['social_icon_display'] == 'on-image-hover') {
                                    $this->get_social_links($team_member, $index);
                                }
                                ?>
                            </div>
                            <?php
                        }

                        ?>
                        <div class="eead-team-member-content-wrapper">
                            <div class="eead-team-member-content">
                                <?php
                                echo $this->get_member_name($team_member);
                                echo $this->get_member_position($team_member);
                                echo $this->get_description($team_member);
                                if ($settings['social_icon_display'] !== 'on-image-hover') {
                                    $this->get_social_links($team_member, $index);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }

}
