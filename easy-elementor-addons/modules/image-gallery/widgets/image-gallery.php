<?php

namespace EasyElementorAddons\Modules\ImageGallery\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class ImageGallery extends Widget_Base {

    public function get_name() {
        return 'eead-image-gallery';
    }

    public function get_title() {
        return esc_html__('Image Gallery', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-gallery-grid';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['light-gallery'];
    }

    public function get_script_depends() {
        return ['light-gallery', 'isotope', 'imagesloaded'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_gallery', [
                'label' => esc_html__('Gallery', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'gallery_type', [
                'label' => esc_html__('Gallery Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'filterable',
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'filterable' => esc_html__('Filterable', 'easy-elementor-addons'),
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'filter_label', [
                'label' => esc_html__('Filter Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'image_group', [
                'label' => esc_html__('Add Images', 'easy-elementor-addons'),
                'type' => Controls_Manager::GALLERY
            ]
        );

        $this->add_control(
            'filterable_image_gallery', [
                'label' => esc_html__('Images', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{filter_label}}',
                'condition' => [
                    'gallery_type' => 'filterable',
                ]
            ]
        );

        $this->add_control(
            'image_gallery', [
                'label' => esc_html__('Add Images', 'easy-elementor-addons'),
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'gallery_type' => 'default',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'filter_section', [
                'label' => esc_html__('Filter', 'easy-elementor-addons'),
                'condition' => [
                    'gallery_type' => 'filterable',
                ]
            ]
        );

        $this->add_control(
            'filter_all_label', [
                'label' => esc_html__('All Filter Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('All', 'easy-elementor-addons'),
                'condition' => [
                    'gallery_type' => 'filterable',
                ]
            ]
        );

        $this->add_responsive_control(
            'filter_alignment', [
                'label' => esc_html__('Align', 'easy-elementor-addons'),
                'label_block' => false,
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right-align',
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
                    '{{WRAPPER}} .eead-ig-filter-list' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_type' => 'filterable',
                ]
            ]
        );

        $this->add_control(
            'filter_duration', [
                'label' => esc_html__('Animation Duration (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'default' => 500,
                'min' => 100,
                'max' => 8000
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings_section', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'easy-elementor-addons'),
                    'masonry' => esc_html__('Masonry', 'easy-elementor-addons')
                ],
                'prefix_class' => 'eead-ig-style-',
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'gallery_columns', [
                'label' => esc_html__('Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'eead-ig-col%s-',
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'caption_type', [
                'label' => esc_html__('Caption Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'caption',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'caption' => esc_html__('Image Caption', 'easy-elementor-addons'),
                    'title' => esc_html__('Image Title', 'easy-elementor-addons'),
                    'description' => esc_html__('Image Description', 'easy-elementor-addons'),
                    'title_description' => esc_html__('Title & Description', 'easy-elementor-addons')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'image_hover_style', [
                'label' => esc_html__('Caption Hover Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'eead-fade-in',
                'options' => [
                    'eead-none' => esc_html__('None', 'easy-elementor-addons'),
                    'eead-fade-in' => esc_html__('Fade In', 'easy-elementor-addons'),
                    'eead-slide-left' => esc_html__('Slide Left', 'easy-elementor-addons'),
                    'eead-slide-right' => esc_html__('Slide Right', 'easy-elementor-addons'),
                    'eead-slide-top' => esc_html__('Slide Top', 'easy-elementor-addons'),
                    'eead-slide-bottom' => esc_html__('Slide Bottom', 'easy-elementor-addons'),
                    'eead-zoom-in' => esc_html__('Zoom In ', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'show_lightbox', [
                'label' => esc_html__('Show Lightbox', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'zoom_icon', [
                'label' => esc_html__('Lightbox Button Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-search',
                    'library' => 'iconfont'
                ],
                'condition' => [
                    'show_lightbox' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'hr', [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'image_dynamic_height', [
                'label' => esc_html__('Dynamic Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => 'grid',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height_px', [
                'label' => esc_html__('Image Height(px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 800,
                    ]
                ],
                'default' => [
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item-box .eead-ig-item-thumbnail' => 'padding-bottom: {{SIZE}}px;',
                ],
                'condition' => [
                    'layout' => 'grid',
                    'image_dynamic_height' => ''
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'image_height_per', [
                'label' => esc_html__('Image Height(%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                    ]
                ],
                'default' => [
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item-box .eead-ig-item-thumbnail' => 'padding-bottom: {{SIZE}}%;',
                ],
                'condition' => [
                    'layout' => 'grid',
                    'image_dynamic_height' => 'yes'
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'image_spacing', [
                'label' => esc_html__('Image Spacing(px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-wrap .eead-ig-item-box' => 'padding: calc({{SIZE}}px/2);',
                    '{{WRAPPER}} .eead-image-gallery-container .eead-ig-wrap' => 'margin: calc({{SIZE}}px/2 * -1);',
                ],
                'render_type' => 'template'
            ]
        );

        $this->end_controls_section();

        /* Style Tabs */
        $this->start_controls_section(
            'filter_style_section', [
                'label' => esc_html__('Filter Buttons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'gallery_type' => 'filterable',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'filter_btn_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter'
            ]
        );

        $this->add_responsive_control(
            'filter_btn_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'filter_btn_padding', [
                'label' => esc_html__('Buttton Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('filter_btn_tabs');

        $this->start_controls_tab('filter_btn_normal', [
            'label' => esc_html__('Normal', 'easy-elementor-addons')
        ]);

        $this->add_control(
            'filter_btn_normal_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'filter_btn_normal_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'filter_btn_normal_border',
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
                'selector' => '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'filter_btn_shadow',
                'selector' => '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('cta_btn_hover', [
            'label' => esc_html__('Active', 'easy-elementor-addons')
        ]);

        $this->add_control(
            'filter_btn_active_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter.eead-ig-active' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'filter_btn_active_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter.eead-ig-active' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'filter_btn_active_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter.eead-ig-active' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'filter_btn_active_shadow',
                'selector' => '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter.eead-ig-active',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'filter_btn_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list .eead-ig-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'filter_btn_spacing', [
                'label' => esc_html__('Button Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-filter-list' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_style_section', [
                'label' => esc_html__('Images', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .eead-ig-wrap .eead-ig-item'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'item_border',
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
                'selector' => '{{WRAPPER}} .eead-ig-wrap .eead-ig-item'
            ]
        );

        $this->add_responsive_control(
            'item_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-wrap .eead-ig-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'caption_style_section', [
                'label' => esc_html__('Overlay Caption', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'overlay_caption_alignment', [
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_caption_v_alignment', [
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
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption' => 'align-items: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'overlay_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption'
            ]
        );

        $this->add_responsive_control(
            'overlay_caption_container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_caption_title_heading', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'overlay_caption_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption h4' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'overlay_caption_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption h4'
            ]
        );

        $this->add_control(
            'overlay_caption_title_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_caption_content_typography_heading', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'overlay_caption_content_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption .eead-ig-item-caption-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'overlay_caption_content_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption .eead-ig-item-caption-text'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'overlay_button_style_section', [
                'label' => esc_html__('Light Box Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'overlay_button_size', [
                'label' => esc_html__('Button Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption .eead-ig-lightbox' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_button_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'overlay_button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('overlay_button_tabs');

        $this->start_controls_tab(
            'overlay_button_style_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'overlay_button_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_button_icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'overlay_button_border',
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
                'selector' => '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'overlay_button_style_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'overlay_button_bg_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox:hover' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_button_icon_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox:hover svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'overlay_button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ig-item .eead-ig-item-caption a.eead-ig-lightbox:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $gallery_settings = array();
        $gallery_settings['layout'] = $settings['layout'];
        $gallery_settings['duration'] = $settings['filter_duration'] ? $settings['filter_duration'] : 500;
        $gallery_settings['widget_id'] = $this->get_id();

        if ($settings['gallery_type'] == 'filterable') {
            $images = $this->get_images();
        } else {
            $images = $settings['image_gallery'];
        }

        $this->add_render_attribute('gallery-settings', [
            'data-settings' => wp_json_encode($gallery_settings),
        ]);
        ?>
        <div id="eead-image-gallery-container-<?php echo esc_attr($id); ?>" class="eead-image-gallery-container" <?php echo $this->get_render_attribute_string('gallery-settings'); ?>>

            <?php $this->render_filters(); ?>

            <div class="eead-ig-wrap">
                <?php
                foreach ($images as $value) {
                    $filter_label = $settings['gallery_type'] == 'filterable' ? $value['filter_label'] : '';
                    ?>
                    <div class="eead-ig-item-box <?php echo esc_attr(strtolower(str_replace(' ', '-', $filter_label))); ?>">
                        <div class="eead-ig-item">
                            <div class="eead-ig-item-thumbnail">
                                <img src="<?php echo esc_url($value['url']); ?>">
                            </div>

                            <div class="eead-ig-item-caption <?php echo esc_attr($settings['image_hover_style']); ?>">
                                <div class="eead-ig-item-caption-content">
                                    <?php
                                    $this->get_caption($value['id']);
                                    ?>
                                </div>
                                <?php if ($settings['show_lightbox'] == 'yes') { ?>
                                    <a href="<?php echo esc_url($value['url']); ?>" class="eead-ig-lightbox" data-elementor-open-lightbox="no">
                                        <?php
                                        Icons_Manager::render_icon($settings['zoom_icon'], ['aria-hidden' => 'true']);
                                        ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (Plugin::instance()->editor->is_edit_mode()) {
            $this->render_editor_script();
        }
    }

    protected function get_caption($image_id) {
        $settings = $this->get_settings_for_display();
        $caption_title = $caption_text = '';
        $image_obj = get_post($image_id);

        if ($settings['caption_type'] == 'caption') {
            $caption_text = $image_obj->post_excerpt;
        } elseif ($settings['caption_type'] == 'title') {
            $caption_text = $image_obj->post_title;
        } elseif ($settings['caption_type'] == 'description') {
            $caption_text = $image_obj->post_content;
        } elseif ($settings['caption_type'] == 'title_description') {
            $caption_title = $image_obj->post_title;
            $caption_text = $image_obj->post_content;
        }

        if ($caption_title) {
            echo '<h4>' . esc_html($caption_title) . '</h4>';
        }

        if ($caption_text) {
            echo '<div class="eead-ig-item-caption-text">' . wp_kses_post($caption_text) . '</div>';
        }
    }

    protected function get_images() {
        $settings = $this->get_settings_for_display();
        $gallery = [];
        $i = 0;
        foreach ($settings['filterable_image_gallery'] as $item) {
            foreach ($item['image_group'] as $key => $image) {
                $gallery[$i]['id'] = $image['id'];
                $gallery[$i]['url'] = $image['url'];
                $gallery[$i]['filter_label'] = !empty($item['filter_label']) ? $item['filter_label'] : 'Group-' . ($key + 1);
                $i++;
            }
        }

        return $gallery;
    }

    protected function render_filters() {
        $settings = $this->get_settings_for_display();
        if ($settings['gallery_type'] == 'filterable') {
            $gallery = $settings['filterable_image_gallery'];
            if (!empty($gallery)) {
                ?>
                <div class="eead-ig-filter-list">
                    <?php if (!empty($settings['filter_all_label'])) { ?>
                        <div class="eead-ig-filter eead-ig-active" data-filter="*">
                            <?php echo esc_html($settings['filter_all_label']); ?>
                        </div>
                    <?php } ?>

                    <?php
                    foreach ($gallery as $index => $item) {
                        $filter_label = $item['filter_label'];
                        if (empty($filter_label)) {
                            $filter_label = esc_html__('Group ', 'easy-elementor-addons') . ($index + 1);
                        }
                        $active_class = empty($settings['filter_all_label']) && $index == 0 ? ' eead-ig-active' : '';
                        ?>
                        <div class="eead-ig-filter<?php echo esc_attr($active_class); ?>" data-filter=".<?php echo esc_attr(strtolower(str_replace(' ', '-', $filter_label))); ?>">
                            <?php echo esc_html($filter_label); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        }
    }

    protected function render_editor_script() {
        $id = '#eead-image-gallery-container-' . $this->get_id();
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                setTimeout(function () {
                    var $gallery_container = $('<?php echo $id; ?>');
                    var $gallery = $gallery_container.find('.eead-ig-wrap');
                    var $settings = $gallery_container.data('settings');

                    if ($settings.layout == 'masonry' || $settings.layout == 'grid') {
                        var layout = $settings.layout == 'grid' ? 'fitRows' : 'masonry';
                        var filterValue = $gallery_container.find('.eead-ig-filter-list .eead-ig-filter').first().data('filter');

                        $gallery.imagesLoaded().done(function () {
                            $gallery.isotope({
                                itemSelector: '.eead-ig-item-box',
                                layoutMode: layout,
                                percentPosition: true,
                                stagger: 30,
                                transitionDuration: $settings.duration + 'ms',
                                filter: filterValue
                            });
                        });

                        $gallery_container.on('click', '.eead-ig-filter', function () {
                            var $this = $(this),
                                filterValue = $this.attr('data-filter');

                            $this.siblings().removeClass('eead-ig-active');
                            $this.addClass('eead-ig-active');
                            $gallery.isotope({
                                itemSelector: '.eead-ig-item-box',
                                layoutMode: layout,
                                percentPosition: true,
                                stagger: 30,
                                transitionDuration: $settings.duration + 'ms',
                                filter: filterValue
                            });
                        });

                        $gallery_container.addClass('eead-isotope-initialized');

                        // Init Popup
                        lightGallery(document.getElementById($gallery_container.attr('id')), {
                            selector: '.eead-ig-lightbox',
                            thumbnail: false,
                        });
                    }
                }, 2000);
            });
        </script>
        <?php
    }

}
