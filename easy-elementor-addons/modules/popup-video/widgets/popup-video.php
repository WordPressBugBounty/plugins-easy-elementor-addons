<?php

namespace EasyElementorAddons\Modules\PopupVideo\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class PopupVideo extends Widget_Base {

    public function get_name() {
        return 'eead-popup-video';
    }

    public function get_title() {
        return esc_html__('Popup Video', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-video-popup';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['light-gallery'];
    }

    public function get_style_depends() {
        return ['light-gallery'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section', [
                'label' => esc_html__('Video', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'video_type', [
                'label' => esc_html__('Video Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'easy-elementor-addons'),
                    'vimeo' => esc_html__('Vimeo', 'easy-elementor-addons'),
                    'custom' => esc_html__('Custom', 'easy-elementor-addons')
                ]
            ]
        );

        $this->add_control(
            'youtube_url', [
                'label' => esc_html__('Youtube Video URL', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'input_type' => 'url',
                'placeholder' => esc_html('https://www.youtube.com/watch?v=MLpWrANjFbI'),
                'default' => esc_html('https://www.youtube.com/watch?v=MLpWrANjFbI'),
                'condition' => [
                    'video_type' => 'youtube'
                ]
            ]
        );

        $this->add_control(
            'vimeo_url', [
                'label' => esc_html__('Vimeo Video URL', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'input_type' => 'url',
                'placeholder' => esc_html('https://vimeo.com/1009918448'),
                'default' => esc_html('https://vimeo.com/1009918448'),
                'condition' => [
                    'video_type' => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'custom_video', [
                'label' => esc_html__('Upload Video', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'condition' => [
                    'video_type' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'video_width', [
                'label' => esc_html__('Video Max Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 400,
                        'max' => 1200,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 800
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trigger_section', [
                'label' => esc_html__('Trigger Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'trigger_type', [
                'label' => esc_html__('Trigger Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'button' => esc_html__('Button', 'easy-elementor-addons'),
                    'image' => esc_html__('Image', 'easy-elementor-addons'),
                    'icon' => esc_html__('Icon', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'play_text', [
                'label' => esc_html__('Play Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Play Video', 'easy-elementor-addons'),
                'default' => esc_html__('Play', 'easy-elementor-addons'),
                'condition' => [
                    'trigger_type' => ['button', 'text']
                ]
            ]
        );

        $this->add_control(
            'play_icon', [
                'label' => esc_html__('Play Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-play-alt-2',
                    'library' => 'iconfont'
                ],
                'condition' => [
                    'trigger_type' => ['button', 'icon']
                ]
            ]
        );

        $this->add_control(
            'play_image', [
                'label' => esc_html__('Play Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'trigger_type' => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'play_image_thumbnail',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'full',
                'condition' => [
                    'trigger_type' => 'image'
                ]
            ]
        );

        $this->add_control(
            'enable_image_play_icon', [
                'label' => esc_html__('Show Play Icon', 'easy-elementor-addons'),
                'description' => esc_html__('Display at the center of the image', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'trigger_type' => 'image',
                ]
            ]
        );

        $this->add_control(
            'image_play_icon', [
                'label' => esc_html__('Play Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-play-alt-2',
                    'library' => 'iconfont'
                ],
                'condition' => [
                    'trigger_type' => 'image',
                    'enable_image_play_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__('Before', 'easy-elementor-addons'),
                    'row-reverse' => esc_html__('After', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-popup-video .eead-vp-button' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => [
                    'trigger_type' => ['button']
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'controls_section', [
                'label' => esc_html__('Player Settings', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'autoplay', [
                'label' => esc_html__('Auto Play', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Enable MUTE below for Auto Play to work.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'mute', [
                'label' => esc_html__('Mute', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'loop', [
                'label' => esc_html__('Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'controls', [
                'label' => esc_html__('Player Control', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'video_type' => 'youtube'
                ]
            ]
        );

        $this->add_control(
            'start', [
                'label' => esc_html__('Start Time (in sec)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'input_type' => 'number',
                'condition' => [
                    'video_type' => 'youtube'
                ]
            ]
        );

        $this->add_control(
            'end', [
                'label' => esc_html__('End Time (in sec)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'input_type' => 'number',
                'condition' => [
                    'video_type' => 'youtube'
                ]
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Show Video Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'video_type' => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'byline', [
                'label' => esc_html__('Show Video Uploader Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'video_type' => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'portrait', [
                'label' => esc_html__('Show User Portrait (Avatar)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'video_type' => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'enable_video_poster', [
                'label' => esc_html__('Enable Video Poster', 'easy-elementor-addons'),
                'description' => esc_html__('Preview of the video\'s content before clicking play.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'video_poster', [
                'label' => esc_html__('Upload Poster Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'enable_video_poster' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section', [
                'label' => esc_html__('Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                    '{{WRAPPER}} .eead-popup-video' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trigger_type' => ['image']
                ]
            ]
        );

        $this->add_control(
            'play_image_width', [
                'label' => esc_html__('Image Max Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-image' => 'max-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'play_image_border',
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
                'selector' => '{{WRAPPER}} .eead-vp-image'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'play_image_shadow',
                'selector' => '{{WRAPPER}} .eead-vp-image'
            ]
        );

        $this->add_control(
            'play_image_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'play_icon_size', [
                'label' => esc_html__('Play Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'size' => 40,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-image span i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vp-image span svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_image_play_icon' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'play_icon_color', [
                'label' => esc_html__('Play Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-image span i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-vp-image span svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'enable_image_play_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'overlay_color', [
                'label' => esc_html__('Image Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-image span' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'enable_image_play_icon' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trigger_type' => ['icon']
                ]
            ]
        );

        $this->add_control(
            'icon_style', [
                'label' => esc_html__('Icon Style', 'easy-elementor-addons'),
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
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-vp-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .eead-vp-icon.eead-vp-style-framed' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-popup-video .eead-vp-icon.eead-vp-style-stacked, {{WRAPPER}} .eead-popup-video .eead-vp-icon.eead-vp-style-stacked.eead-vp-ripple:before' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'icon_style' => 'stacked',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 24,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 250,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-vp-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_circle_size', [
                'label' => esc_html__('Icon Outer Size', 'easy-elementor-addons'),
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
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_style' => 'framed',
                ]
            ]
        );

        $this->add_control(
            'icon_radius_advanced_show', [
                'label' => esc_html__('Advanced Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'condition' => [
                    'icon_style!' => 'default',
                ]
            ]
        );

        $this->add_control(
            'icon_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon, {{WRAPPER}} .eead-vp-icon.eead-vp-ripple:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_style!' => 'default',
                    'icon_radius_advanced_show!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'icon_radius_advanced', [
                'label' => esc_html__('Radius', 'easy-elementor-addons'),
                'description' => sprintf(__('For example: <b>%1s</b> or Go <a href="%2s" target="_blank">this link</a> and copy and paste the radius value.', 'easy-elementor-addons'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
                'type' => Controls_Manager::TEXT,
                'default' => '75% 25% 43% 57% / 46% 29% 71% 54%',
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-icon, {{WRAPPER}} .eead-vp-icon.eead-vp-ripple:before' => 'border-radius: {{VALUE}};'
                ],
                'condition' => [
                    'icon_style!' => 'default',
                    'icon_radius_advanced_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'enable_ripple', [
                'label' => esc_html__('Enable Ripple Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'icon_style' => 'stacked',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trigger_type' => ['button']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-vp-button'
            ]
        );

        $this->add_control(
            'icon_indent', [
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
                    'play_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-vp-button'
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
                'selector' => '{{WRAPPER}} .eead-vp-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .eead-vp-button'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-vp-button:hover'
            ]
        );

        $this->add_control(
            'button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-vp-button:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .eead-vp-button:hover'
            ]
        );

        $this->add_control(
            'button_hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_button() {
        $settings = $this->get_settings_for_display();

        if ($settings['trigger_type'] == 'button') {
            if (!empty($settings['play_icon']['value'])) {
                Icons_Manager::render_icon($settings['play_icon'], ['aria-hidden' => 'true']);
            }
            echo '<span>' . esc_html($settings['play_text']) . '</span>';
        } elseif ($settings['trigger_type'] == 'image') {
            echo Group_Control_Image_Size::get_attachment_image_html($settings, 'play_image_thumbnail', 'play_image');
            if ($settings['enable_image_play_icon']) {
                echo '<span>';
                Icons_Manager::render_icon($settings['image_play_icon'], ['aria-hidden' => 'true']);
                echo '</span>';
            }
        } elseif ($settings['trigger_type'] == 'text') {
            echo '<span>' . esc_html($settings['play_text']) . '</span>';
        } elseif ($settings['trigger_type'] == 'icon') {
            Icons_Manager::render_icon($settings['play_icon'], ['aria-hidden' => 'true']);
        }
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('popup-video', [
            'id' => esc_attr('eead-video-popup-' . $this->get_id()),
            'class' => ['eead-video-popup-button', 'eead-vp-' . esc_attr($settings['trigger_type'])],
            'data-elementor-open-lightbox' => 'no',
            'data-video-type' => esc_attr($settings['video_type']),
            'data-video-width' => isset($settings['video_width']['size']) ? esc_attr($settings['video_width']['size'] . $settings['video_width']['unit']) : '800px'
        ]);

        if ($settings['enable_video_poster'] && isset($settings['video_poster']['url'])) {
            $this->add_render_attribute('popup-video', [
                'data-poster' => esc_url($settings['video_poster']['url'])
            ]);
        }

        if ($settings['video_type'] == 'youtube') {
            $video_settings = [
                'autoplay' => $settings['autoplay'] ? 1 : 0,
                'controls' => $settings['controls'] ? 1 : 0,
                'mute' => $settings['mute'] ? true : false,
                'loop' => $settings['loop'] ? 1 : 0,
                'start' => $settings['start'] ? $settings['start'] : false,
                'end' => $settings['end'] ? $settings['end'] : false
            ];

            $this->add_render_attribute('popup-video', [
                'href' => $settings['youtube_url'],
                'data-settings' => wp_json_encode($video_settings)
            ]);
        } elseif ($settings['video_type'] == 'vimeo') {
            $video_settings = [
                'autoplay' => $settings['autoplay'] ? 1 : 0,
                'loop' => $settings['loop'] ? 1 : 0,
                'mute' => $settings['mute'] ? 1 : 0,
                'title' => $settings['title'] ? 1 : 0,
                'byline' => $settings['byline'] ? 1 : 0,
                'portrait' => $settings['portrait'] ? 1 : 0
            ];

            $this->add_render_attribute('popup-video', [
                'href' => $settings['vimeo_url'],
                'data-settings' => wp_json_encode($video_settings)
            ]);
        } elseif ($settings['video_type'] == 'custom') {
            $this->add_render_attribute('popup-video', [
                'data-html' => esc_attr('#eead-custom-video-' . $this->get_id())
            ]);
            ?>
            <div id="eead-custom-video-<?php echo esc_attr($this->get_id()); ?>" style="display: none;">
                <video class="lg-video-object lg-html5" controls preload="none">
                    <source src="<?php echo esc_url($settings['custom_video']['url']); ?>" type="video/mp4">
                    <?php echo esc_html__('Your browser does not support HTML5 video.', 'easy-elementor-addons'); ?>
                </video>
            </div>
            <?php
        }

        if ($settings['button_hover_animation']) {
            $this->add_render_attribute('popup-video', 'class', 'elementor-animation-' . esc_attr($settings['button_hover_animation']));
        }

        if ($settings['trigger_type'] == 'icon') {
            $this->add_render_attribute('popup-video', 'class', 'eead-vp-style-' . esc_attr($settings['icon_style']));
        }

        if ($settings['enable_ripple']) {
            $this->add_render_attribute('popup-video', 'class', 'eead-vp-ripple');
        }
        ?>

        <div class="eead-popup-video">
            <a <?php echo $this->get_render_attribute_string('popup-video'); ?>>
                <?php $this->render_button(); ?>
            </a>
        </div>
        <?php
    }

}
