<?php

namespace EasyElementorAddons\Modules\TeamMember\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
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
class TeamMember extends Widget_Base {

    public function get_name() {
        return 'eead-team-member';
    }

    public function get_title() {
        return esc_html__('Team', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-team';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_details', [
                'label' => esc_html__('Details', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
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
                'default' => esc_html__('John Doe', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'position', [
                'label' => esc_html__('Designation', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('WordPress Developer', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'link_type', [
                'label' => esc_html__('Link Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'image' => esc_html__('Image', 'easy-elementor-addons'),
                    'title' => esc_html__('Title', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://www.your-link.com',
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'link_type!' => 'none',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_social_links', [
                'label' => esc_html__('Social Links', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'enable_social_links', [
                'label' => esc_html__('Show Social Links', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon_label', array(
                'label' => esc_html__('Icon Label', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
            )
        );

        $repeater->add_control(
            'social_icon', [
                'label' => esc_html__('Social Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => array(
                    'value' => 'icofont-facebook',
                    'library' => 'iconfont'
                )
            ]
        );

        $repeater->add_control(
            'social_link', [
                'label' => esc_html__('Social Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__('Enter URL', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'social', [
                'label' => esc_html__('Add Social Links', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'social_icon_label' => 'Facebook',
                        'social_icon' => [
                            'value' => 'icofont-facebook',
                        ],
                        'social_link' => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'social_icon_label' => 'Twitter',
                        'social_icon' => [
                            'value' => 'icofont-x-twitter',
                        ],
                        'social_link' => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'social_icon_label' => 'Youtube',
                        'social_icon' => [
                            'value' => 'icofont-youtube',
                        ],
                        'social_link' => [
                            'url' => '#',
                        ],
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ social_icon_label }}}',
                'condition' => [
                    'enable_social_links' => 'yes',
                ]
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
                'name' => 'image',
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
                    '{{WRAPPER}} .eead-team-member-content > *' => 'color: {{VALUE}}',
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
                ],
                'condition' => [
                    'content_display' => 'below-image'
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
                    ],
                ],
                'selector' => '{{WRAPPER}} .eead-team-member-image',
                'condition' => [
                    'content_display' => 'below-image'
                ]
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
    }

    protected function get_image() {
        $settings = $this->get_settings();
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings);

        if (!empty($settings['image']['url'])) {
            if ($settings['link_type'] == 'image' && $settings['link']['url'] != '') {
                $image = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('link'), $image_html);
            } else {
                $image = $image_html;
            }
        }
        return $image;
    }

    protected function get_social_links() {
        $settings = $this->get_settings_for_display();
        $count = 1;
        if ($settings['enable_social_links'] == 'yes') {
            ?>
            <div class="eead-team-member-social-links">
                <?php
                if (isset($settings['social']) && !empty($settings['social'])) {
                    foreach ($settings['social'] as $item) {
                        ?>
                        <?php
                        if (!empty($item['social_link']['url']) && !empty($item['social_icon'])) {
                            $this->add_link_attributes('social-link' . $count, $item['social_link']);
                            ?>
                            <a <?php echo $this->get_render_attribute_string('social-link' . $count); ?>>
                                <?php Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']); ?>
                            </a>
                            <?php
                        }
                        $count++;
                    }
                }
                ?>
            </div>
            <?php
        }
    }

    protected function get_description() {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('description', 'basic');
        $this->add_render_attribute('description', 'class', 'eead-team-member-description');

        if (!empty($settings['description'])) {
            ?>
            <div <?php echo $this->get_render_attribute_string('description'); ?>>
                <?php echo parse_wisiwyg_content($settings['description']); ?>
            </div>
            <?php
        }
    }

    protected function get_member_name() {
        $settings = $this->get_settings_for_display();
        $member_name = '';
        $this->add_inline_editing_attributes('name', 'none');
        $this->add_render_attribute('name', 'class', 'eead-team-member-name');

        if ($settings['name'] != '') {
            if ($settings['link_type'] == 'title' && $settings['link']['url'] != '') {
                $member_name .= sprintf('<%1$s %2$s><a %3$s>%4$s</a></%1$s>', 'h4', $this->get_render_attribute_string('name'), $this->get_render_attribute_string('link'), esc_html($settings['name']));
            } else {
                $member_name .= sprintf('<%1$s %2$s>%3$s</%1$s>', 'h4', $this->get_render_attribute_string('name'), esc_html($settings['name']));
            }
        }
        return $member_name;
    }

    protected function get_member_position() {
        $settings = $this->get_settings_for_display();
        $position = '';
        $this->add_inline_editing_attributes('position', 'none');
        $this->add_render_attribute('position', 'class', 'eead-team-member-position');

        if ($settings['position'] != '') {
            $position .= sprintf('<%1$s %2$s>%3$s</%1$s>', 'h5', $this->get_render_attribute_string('position'), esc_html($settings['position']));
        }
        return $position;
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $custom_height_class = $settings['custom_image_height'] == 'yes' ? 'eead-team-image-custom-height' : '';
        $this->add_render_attribute('team-wrapper', [
            'class' => [
                'eead-team-member',
                $custom_height_class,
                'eead-content-' . esc_attr($settings['content_display']),
            ]
        ]);

        if ($settings['social_icon_display'] == 'on-image-hover') {
            $this->add_render_attribute('team-wrapper', [
                'class' => [
                    'eead-social-' . esc_attr($settings['social_icon_display']),
                    'eead-social-pos-' . ($settings['social_icon_position'] ? esc_attr($settings['social_icon_position']) : 'bottom-center')
                ]
            ]);
        }

        ?>
        <div <?php $this->print_render_attribute_string('team-wrapper'); ?>>
            <?php
            if (!empty($settings['image']['url'])) {
                ?>
                <div class="eead-team-member-image <?php echo esc_attr($custom_height_class); ?>">
                    <?php
                    echo $this->get_image();

                    if ($settings['social_icon_display'] == 'on-image-hover') {
                        $this->get_social_links();
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <div class="eead-team-member-content-wrapper">
                <div class="eead-team-member-content">
                    <?php
                    echo $this->get_member_name();
                    echo $this->get_member_position();
                    echo $this->get_description();
                    if ($settings['social_icon_display'] !== 'on-image-hover') {
                        $this->get_social_links();
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

}
