<?php

namespace EasyElementorAddons\Modules\Marquee\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Marquee Widget
 */
class Marquee extends Widget_Base {

    public function get_name() {
        return 'eead-marquee';
    }

    public function get_title() {
        return esc_html__('Marquee', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-marquee';
    }

    public function get_keywords() {
        return ['marquee', 'scrolling text', 'ticker', 'news ticker', 'text slider', 'running text', 'logo marquee', 'posts ticker', 'eead'];
    }

    /**
     * Drop the inner .elementor-widget-container wrapper when Elementor's
     * Optimized Markup feature is active.
     */
    public function has_widget_inner_wrapper(): bool {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        // Images can come from custom items, or from posts when featured images are on.
        $has_media = [
            'relation' => 'or',
            'terms' => [
                ['name' => 'source', 'operator' => '==', 'value' => 'custom'],
                [
                    'terms' => [
                        ['name' => 'source', 'operator' => '==', 'value' => 'posts'],
                        ['name' => 'posts_show_image', 'operator' => '==', 'value' => 'yes'],
                    ]
                ],
            ]
        ];

        $this->start_controls_section(
            'section_items', [
                'label' => esc_html__('Items', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'source', [
                'label' => esc_html__('Source', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => esc_html__('Custom Items', 'easy-elementor-addons'),
                    'posts' => esc_html__('Posts', 'easy-elementor-addons'),
                ]
            ]
        );

        $post_types = eead_get_post_types();
        unset($post_types['0'], $post_types['attachment']);

        $this->add_control(
            'post_type', [
                'label' => esc_html__('Post Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $post_types,
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'post_categories', [
                'label' => esc_html__('Categories', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => $this->category_options(),
                'description' => esc_html__('Leave empty to show posts from every category.', 'easy-elementor-addons'),
                'condition' => [
                    'source' => 'posts',
                    'post_type' => 'post'
                ]
            ]
        );

        $this->add_control(
            'posts_count', [
                'label' => esc_html__('Number of Posts', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 50,
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'posts_orderby', [
                'label' => esc_html__('Order By', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'easy-elementor-addons'),
                    'modified' => esc_html__('Last Modified', 'easy-elementor-addons'),
                    'title' => esc_html__('Title', 'easy-elementor-addons'),
                    'comment_count' => esc_html__('Comment Count', 'easy-elementor-addons'),
                    'rand' => esc_html__('Random', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'posts_order', [
                'label' => esc_html__('Order', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'easy-elementor-addons'),
                    'ASC' => esc_html__('Ascending', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'source' => 'posts',
                    'posts_orderby!' => 'rand'
                ]
            ]
        );

        $this->add_control(
            'posts_exclude_current', [
                'label' => esc_html__('Exclude Current Post', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'posts_show_image', [
                'label' => esc_html__('Show Featured Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'posts_show_date', [
                'label' => esc_html__('Show Date', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $this->add_control(
            'posts_link', [
                'label' => esc_html__('Link to Post', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'source' => 'posts'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Marquee item', 'easy-elementor-addons'),
                'description' => esc_html__('You can use <em>, <strong> and <mark> to highlight words.', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'media', [
                'label' => esc_html__('Icon / Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'none',
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ],
                ]
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'media' => 'icon'
                ]
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'media' => 'image'
                ]
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com'
            ]
        );

        $repeater->add_control(
            'item_custom_style', [
                'label' => esc_html__('Custom Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $repeater->add_control(
            'item_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.eead-tm-item, {{WRAPPER}} {{CURRENT_ITEM}}.eead-tm-item a' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'item_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.eead-tm-item' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'item_outline', [
                'label' => esc_html__('Outline Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'item_custom_style' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'item_outline_width', [
                'label' => esc_html__('Outline Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 6,
                        'step' => 0.5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.eead-tm-item' => '--eead-tm-stroke: {{SIZE}}px',
                ],
                'condition' => [
                    'item_custom_style' => 'yes',
                    'item_outline' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'items', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['text' => esc_html__('Fast & lightweight', 'easy-elementor-addons')],
                    ['text' => esc_html__('Fully responsive', 'easy-elementor-addons')],
                    ['text' => esc_html__('No coding needed', 'easy-elementor-addons')],
                    ['text' => esc_html__('Easy to customize', 'easy-elementor-addons')],
                    ['text' => esc_html__('Built for Elementor', 'easy-elementor-addons')],
                ],
                'title_field' => '{{{ text }}}',
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'default' => 'medium',
                'separator' => 'before',
                'conditions' => $has_media
            ]
        );

        $this->add_control(
            'html_tag', [
                'label' => esc_html__('HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'span',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_separator', [
                'label' => esc_html__('Separator', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'separator_type', [
                'label' => esc_html__('Separator', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'icon',
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ],
                    'text' => [
                        'title' => esc_html__('Text', 'easy-elementor-addons'),
                        'icon' => 'eicon-t-letter',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ],
                ]
            ]
        );

        $this->add_control(
            'separator_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-asterisk',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'separator_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'separator_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '/',
                'condition' => [
                    'separator_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'separator_image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'separator_type' => 'image'
                ]
            ]
        );

        $this->add_control(
            'separator_spin', [
                'label' => esc_html__('Spin Separator', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'eead-tm-spin-',
                'condition' => [
                    'separator_type!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'separator_spin_duration', [
                'label' => esc_html__('Spin Duration (s)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-separator' => '--eead-tm-spin: {{SIZE}}s',
                ],
                'condition' => [
                    'separator_type!' => 'none',
                    'separator_spin' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_motion', [
                'label' => esc_html__('Motion', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'direction', [
                'label' => esc_html__('Direction', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'up' => [
                        'title' => esc_html__('Up', 'easy-elementor-addons'),
                        'icon' => 'eicon-arrow-up',
                    ],
                    'down' => [
                        'title' => esc_html__('Down', 'easy-elementor-addons'),
                        'icon' => 'eicon-arrow-down',
                    ],
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'speed', [
                'label' => esc_html__('Speed (px per second)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 500,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'size' => 60,
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'vertical_height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee.eead-tm-vertical' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'direction' => ['up', 'down']
                ]
            ]
        );

        $this->add_control(
            'hover_action', [
                'label' => esc_html__('On Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'pause',
                'options' => [
                    'none' => esc_html__('Keep Moving', 'easy-elementor-addons'),
                    'pause' => esc_html__('Pause', 'easy-elementor-addons'),
                    'slow' => esc_html__('Slow Down', 'easy-elementor-addons'),
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'scroll_effect', [
                'label' => esc_html__('Page Scroll Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'speed' => esc_html__('Speed Up While Scrolling', 'easy-elementor-addons'),
                    'direction' => esc_html__('Follow Scroll Direction', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('Follow Scroll Direction reverses the marquee while the page is scrolled up.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'draggable', [
                'label' => esc_html__('Drag to Scroll', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Visitors can drag or swipe the marquee.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'reduced_motion', [
                'label' => esc_html__('Respect Reduced Motion', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Shows the items without movement to visitors who turned off animations in their system settings.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'edge_fade', [
                'label' => esc_html__('Fade Edges', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'prefix_class' => 'eead-tm-fade-',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'edge_fade_size', [
                'label' => esc_html__('Fade Size (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 40,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-fade: {{SIZE}}%',
                ],
                'condition' => [
                    'edge_fade' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_rows', [
                'label' => esc_html__('Tilt & Second Row', 'easy-elementor-addons'),
                'condition' => [
                    'direction' => ['left', 'right']
                ]
            ]
        );

        $this->add_responsive_control(
            'row_rotate', [
                'label' => esc_html__('Tilt (deg)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 20,
                        'step' => 0.5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-1' => '--eead-tm-rotate: {{SIZE}}deg',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'second_row', [
                'label' => esc_html__('Second Row', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Adds a second band with the same items. Tilt the two rows in opposite directions to cross them.', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'row2_reverse', [
                'label' => esc_html__('Opposite Direction', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'second_row' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'row2_rotate', [
                'label' => esc_html__('Second Row Tilt (deg)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 20,
                        'step' => 0.5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-2' => '--eead-tm-rotate: {{SIZE}}deg',
                ],
                'render_type' => 'template',
                'condition' => [
                    'second_row' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'row2_offset', [
                'label' => esc_html__('Space Between Rows', 'easy-elementor-addons'),
                'description' => esc_html__('Use a negative value to overlap the rows.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-2' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'second_row' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'row2_on_top', [
                'label' => esc_html__('Second Row on Top', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-2' => 'z-index: 3',
                ],
                'condition' => [
                    'second_row' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Marquee */
        $this->start_controls_section(
            'section_style_marquee', [
                'label' => esc_html__('Marquee', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'marquee_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-marquee'
            ]
        );

        $this->add_responsive_control(
            'marquee_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'marquee_border',
                'selector' => '{{WRAPPER}} .eead-marquee'
            ]
        );

        $this->add_responsive_control(
            'marquee_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'marquee_shadow',
                'selector' => '{{WRAPPER}} .eead-marquee'
            ]
        );

        $this->add_responsive_control(
            'items_gap', [
                'label' => esc_html__('Space Between', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-gap: {{SIZE}}{{UNIT}}',
                ],
                'render_type' => 'template',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'items_align', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'baseline' => [
                        'title' => esc_html__('Baseline', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-group' => 'align-items: {{VALUE}}',
                ],
                'condition' => [
                    'direction' => ['left', 'right']
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Items */
        $this->start_controls_section(
            'section_style_items', [
                'label' => esc_html__('Items', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .eead-tm-item'
            ]
        );

        $this->add_control(
            'text_style', [
                'label' => esc_html__('Text Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'filled',
                'options' => [
                    'filled' => esc_html__('Filled', 'easy-elementor-addons'),
                    'outline' => esc_html__('Outline', 'easy-elementor-addons'),
                    'alternate' => esc_html__('Alternate Filled & Outline', 'easy-elementor-addons'),
                    'gradient' => esc_html__('Gradient', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-tm-text-'
            ]
        );

        $this->add_control(
            'gradient_start', [
                'label' => esc_html__('Gradient Start', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#6D28D9',
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-grad-1: {{VALUE}}',
                ],
                'condition' => [
                    'text_style' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'gradient_end', [
                'label' => esc_html__('Gradient End', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EC4899',
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-grad-2: {{VALUE}}',
                ],
                'condition' => [
                    'text_style' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'gradient_angle', [
                'label' => esc_html__('Gradient Angle', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                    ],
                ],
                'default' => [
                    'size' => 90,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-grad-angle: {{SIZE}}deg',
                ],
                'condition' => [
                    'text_style' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'outline_width', [
                'label' => esc_html__('Outline Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 6,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'size' => 1.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-marquee' => '--eead-tm-stroke: {{SIZE}}px',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'text_style', 'operator' => 'in', 'value' => ['outline', 'alternate']],
                        [
                            'terms' => [
                                ['name' => 'second_row', 'operator' => '==', 'value' => 'yes'],
                                ['name' => 'row2_text_style', 'operator' => '==', 'value' => 'outline'],
                            ]
                        ],
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'item_text_shadow',
                'selector' => '{{WRAPPER}} .eead-tm-item',
                'condition' => [
                    'text_style!' => 'gradient'
                ]
            ]
        );

        $this->start_controls_tabs('item_style_tabs');

        $this->start_controls_tab(
            'item_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'item_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item, {{WRAPPER}} .eead-tm-item a' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_style!' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'item_background', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'highlight_color', [
                'label' => esc_html__('Highlight Color', 'easy-elementor-addons'),
                'description' => esc_html__('For words wrapped in <em>, <strong> or <mark>.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item em, {{WRAPPER}} .eead-tm-item strong, {{WRAPPER}} .eead-tm-item mark' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom',
                    'text_style!' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'mark_background', [
                'label' => esc_html__('Mark Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item mark' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'meta_color', [
                'label' => esc_html__('Date Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-meta' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'posts',
                    'posts_show_date' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'item_text_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover, {{WRAPPER}} .eead-tm-item:hover a' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_style!' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'item_background_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_fill_on_hover', [
                'label' => esc_html__('Fill Outline on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'eead-tm-hover-fill-',
                'condition' => [
                    'text_style' => ['outline', 'alternate']
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'item_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .eead-tm-item'
            ]
        );

        $this->add_responsive_control(
            'item_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Item Icon / Image */
        $this->start_controls_section(
            'section_style_media', [
                'label' => esc_html__('Item Icon / Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => $has_media
            ]
        );

        $this->add_control(
            'media_position', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'before',
                'options' => [
                    'before' => [
                        'title' => esc_html__('Before', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => esc_html__('After', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'eead-tm-media-'
            ]
        );

        $this->add_responsive_control(
            'media_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 1,
                    'unit' => 'em',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-media' => '--eead-tm-media-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'media_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'default' => [
                    'size' => 0.4,
                    'unit' => 'em',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item' => 'gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'media_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-media' => 'color: {{VALUE}}; -webkit-text-stroke: 0',
                    '{{WRAPPER}} .eead-tm-media svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_responsive_control(
            'media_radius', [
                'label' => esc_html__('Image Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'media_image_heading', [
                'label' => esc_html__('Image Effects', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('media_image_tabs');

        $this->start_controls_tab(
            'media_image_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'media_grayscale', [
                'label' => esc_html__('Grayscale (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-media img' => 'filter: grayscale({{SIZE}}%)',
                ]
            ]
        );

        $this->add_control(
            'media_opacity', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.05,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-media img' => 'opacity: {{SIZE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'media_image_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'media_grayscale_hover', [
                'label' => esc_html__('Grayscale (%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover .eead-tm-media img' => 'filter: grayscale({{SIZE}}%)',
                ]
            ]
        );

        $this->add_control(
            'media_opacity_hover', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover .eead-tm-media img' => 'opacity: {{SIZE}}',
                ]
            ]
        );

        $this->add_control(
            'media_scale_hover', [
                'label' => esc_html__('Scale', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.8,
                        'max' => 1.5,
                        'step' => 0.05,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-item:hover .eead-tm-media img' => 'transform: scale({{SIZE}})',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* Style: Second Row */
        $this->start_controls_section(
            'section_style_row2', [
                'label' => esc_html__('Second Row', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'second_row' => 'yes',
                    'direction' => ['left', 'right']
                ]
            ]
        );

        $this->add_control(
            'row2_style_note', [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('The second row uses the first row\'s styles. Anything set here overrides them.', 'easy-elementor-addons'),
                'content_classes' => 'elementor-descriptor'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'row2_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-marquee.eead-tm-row-2'
            ]
        );

        $this->add_control(
            'row2_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-2 .eead-tm-item, {{WRAPPER}} .eead-tm-row-2 .eead-tm-item a' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'text_style!' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'row2_separator_color', [
                'label' => esc_html__('Separator Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-row-2 .eead-tm-separator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-tm-row-2 .eead-tm-separator svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'row2_text_style', [
                'label' => esc_html__('Text Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Same as First Row', 'easy-elementor-addons'),
                    'filled' => esc_html__('Filled', 'easy-elementor-addons'),
                    'outline' => esc_html__('Outline', 'easy-elementor-addons'),
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'row2_border',
                'selector' => '{{WRAPPER}} .eead-marquee.eead-tm-row-2'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'row2_shadow',
                'selector' => '{{WRAPPER}} .eead-marquee.eead-tm-row-2'
            ]
        );

        $this->end_controls_section();

        /* Style: Separator */
        $this->start_controls_section(
            'section_style_separator', [
                'label' => esc_html__('Separator', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'separator_type!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'separator_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 4,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 0.5,
                    'unit' => 'em',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-separator' => '--eead-tm-sep-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'separator_type!' => 'text'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'separator_typography',
                'selector' => '{{WRAPPER}} .eead-tm-separator',
                'condition' => [
                    'separator_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'separator_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-separator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-tm-separator svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'separator_type!' => 'image'
                ]
            ]
        );

        $this->add_responsive_control(
            'separator_offset', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-tm-separator' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'direction' => ['left', 'right']
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Text allowed in an item: plain text with a few inline highlight tags. */
    private function item_text($text) {
        return wp_kses($text, [
            'em' => [],
            'strong' => [],
            'mark' => [],
            'b' => [],
            'i' => [],
            'span' => ['class' => []],
        ]);
    }

    private function category_options() {
        $options = [];
        $terms = get_terms(['taxonomy' => 'category', 'hide_empty' => false]);
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }
        return $options;
    }

    private function image_url($id, $url, $settings) {
        if ($id) {
            $src = Group_Control_Image_Size::get_attachment_image_src($id, 'image', $settings);
            if ($src) {
                return $src;
            }
        }
        return $url;
    }

    /** Items in one shape, whether they come from the repeater or from posts. */
    private function collect_items($settings) {
        $items = [];

        if ('posts' === $settings['source']) {
            $args = [
                'post_type' => $settings['post_type'] ?: 'post',
                'post_status' => 'publish',
                'posts_per_page' => max(1, min(50, (int) $settings['posts_count'])),
                'orderby' => $settings['posts_orderby'],
                'order' => 'ASC' === $settings['posts_order'] ? 'ASC' : 'DESC',
                'ignore_sticky_posts' => true,
                'no_found_rows' => true,
            ];
            if ('post' === $args['post_type'] && !empty($settings['post_categories'])) {
                $args['category__in'] = array_map('intval', (array) $settings['post_categories']);
            }
            if ('yes' === $settings['posts_exclude_current'] && is_singular()) {
                $args['post__not_in'] = [get_queried_object_id()];
            }

            foreach (get_posts($args) as $post) {
                $thumb = 'yes' === $settings['posts_show_image'] ? get_post_thumbnail_id($post) : 0;
                $items[] = [
                    'id' => 'post-' . $post->ID,
                    'text' => esc_html(get_the_title($post)),
                    'meta' => 'yes' === $settings['posts_show_date'] ? get_the_date('', $post) : '',
                    'icon' => null,
                    'image' => $thumb ? $this->image_url($thumb, '', $settings) : '',
                    'alt' => '',
                    'link' => 'yes' === $settings['posts_link'] ? ['url' => get_permalink($post)] : null,
                    'outline' => false,
                ];
            }
            return $items;
        }

        foreach ((array) $settings['items'] as $item) {
            $image = '';
            $alt = '';
            if ('image' === $item['media'] && !empty($item['image']['url'])) {
                $image_id = !empty($item['image']['id']) ? (int) $item['image']['id'] : 0;
                $image = $this->image_url($image_id, $item['image']['url'], $settings);
                $alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';
            }
            $items[] = [
                'id' => $item['_id'],
                'text' => $this->item_text($item['text']),
                'meta' => '',
                'icon' => 'icon' === $item['media'] && !empty($item['icon']['value']) ? $item['icon'] : null,
                'image' => $image,
                'alt' => $alt,
                'link' => !empty($item['link']['url']) ? $item['link'] : null,
                'outline' => 'yes' === $item['item_custom_style'] && 'yes' === $item['item_outline'],
            ];
        }
        return $items;
    }

    private function render_media($item) {
        if ($item['icon']) {
            echo '<span class="eead-tm-media eead-tm-media-icon">';
            Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
            echo '</span>';
        } elseif ($item['image']) {
            echo '<span class="eead-tm-media eead-tm-media-image"><img src="' . esc_url($item['image']) . '" alt="' . esc_attr($item['alt']) . '" loading="lazy" decoding="async"></span>';
        }
    }

    private function render_separator($settings) {
        $type = $settings['separator_type'];
        if ('icon' === $type && !empty($settings['separator_icon']['value'])) {
            echo '<span class="eead-tm-separator" aria-hidden="true"><span class="eead-tm-separator-inner">';
            Icons_Manager::render_icon($settings['separator_icon'], ['aria-hidden' => 'true']);
            echo '</span></span>';
        } elseif ('text' === $type && '' !== $settings['separator_text']) {
            echo '<span class="eead-tm-separator" aria-hidden="true"><span class="eead-tm-separator-inner">' . esc_html($settings['separator_text']) . '</span></span>';
        } elseif ('image' === $type && !empty($settings['separator_image']['url'])) {
            echo '<span class="eead-tm-separator eead-tm-separator-image" aria-hidden="true"><span class="eead-tm-separator-inner"><img src="' . esc_url($settings['separator_image']['url']) . '" alt="" loading="lazy" decoding="async"></span></span>';
        }
    }

    private function render_row($settings, $items, $row, $direction) {
        $vertical = in_array($direction, ['up', 'down'], true);
        $tag = eead_check_allowed_html_tags($settings['html_tag'], 'span');
        $key = 'marquee-' . $row;

        $speed = [];
        foreach (['', '_tablet', '_mobile'] as $device) {
            if (isset($settings['speed' . $device]['size']) && '' !== $settings['speed' . $device]['size']) {
                $speed[ltrim($device, '_') ?: 'desktop'] = (float) $settings['speed' . $device]['size'];
            }
        }

        $this->add_render_attribute($key, [
            'class' => ['eead-marquee', 'eead-tm-row-' . $row, 'eead-tm-' . $direction, $vertical ? 'eead-tm-vertical' : 'eead-tm-horizontal'],
            'data-settings' => wp_json_encode([
                'direction' => $direction,
                'speed' => $speed,
                'hover' => in_array($settings['hover_action'], ['none', 'pause', 'slow'], true) ? $settings['hover_action'] : 'pause',
                'scroll' => in_array($settings['scroll_effect'], ['none', 'speed', 'direction'], true) ? $settings['scroll_effect'] : 'none',
                'drag' => 'yes' === $settings['draggable'],
                'reducedMotion' => 'yes' === $settings['reduced_motion'],
            ]),
        ]);

        if ('yes' === $settings['draggable']) {
            $this->add_render_attribute($key, 'class', 'eead-tm-draggable');
        }
        if (2 === $row && in_array($settings['row2_text_style'], ['filled', 'outline'], true)) {
            $this->add_render_attribute($key, 'class', 'eead-tm-row-text-' . $settings['row2_text_style']);
        }
        // The second row repeats the first, so screen readers only hear it once.
        if (2 === $row) {
            $this->add_render_attribute($key, 'aria-hidden', 'true');
        }
        ?>
        <div <?php $this->print_render_attribute_string($key); ?>>
            <div class="eead-tm-track">
                <div class="eead-tm-group">
                    <?php
                    foreach ($items as $index => $item) {
                        $item_key = $key . '-item-' . $index;
                        $link_key = $key . '-link-' . $index;
                        $this->add_render_attribute($item_key, 'class', ['eead-tm-item', 'elementor-repeater-item-' . $item['id']]);
                        if ($item['outline']) {
                            $this->add_render_attribute($item_key, 'class', 'eead-tm-outline');
                        }
                        if ($item['link']) {
                            $this->add_link_attributes($link_key, $item['link']);
                            if (2 === $row) {
                                $this->add_render_attribute($link_key, 'tabindex', '-1');
                            }
                        }
                        ?>
                        <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string($item_key); ?>>
                            <?php if ($item['link']) { ?>
                                <a <?php $this->print_render_attribute_string($link_key); ?>>
                            <?php
                            }
                            $this->render_media($item);
                            // Text is escaped in collect_items(): esc_html for posts, item_text() for custom items.
                            echo '<span class="eead-tm-text">' . $item['text'] . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            if ($item['meta']) {
                                echo '<span class="eead-tm-meta">' . esc_html($item['meta']) . '</span>';
                            }
                            if ($item['link']) {
                                echo '</a>';
                            }
                            ?>
                        </<?php echo esc_attr($tag); ?>>
                        <?php
                        $this->render_separator($settings);
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    /** Whether either row is tilted on any device. */
    private function is_tilted($settings, $second_row) {
        $controls = $second_row ? ['row_rotate', 'row2_rotate'] : ['row_rotate'];
        foreach ($controls as $control) {
            foreach (['', '_tablet', '_mobile'] as $device) {
                if (!empty($settings[$control . $device]['size'])) {
                    return true;
                }
            }
        }
        return false;
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $this->collect_items($settings);

        if (empty($items)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="eead-tm-empty">' . esc_html__('No posts found for this query.', 'easy-elementor-addons') . '</div>';
            }
            return;
        }

        $direction = in_array($settings['direction'], ['left', 'right', 'up', 'down'], true) ? $settings['direction'] : 'left';
        $second_row = 'yes' === $settings['second_row'] && in_array($direction, ['left', 'right'], true);

        $classes = ['eead-tm-rows'];
        if ($second_row) {
            $classes[] = 'eead-tm-has-row-2';
        }
        if ($this->is_tilted($settings, $second_row) && !in_array($direction, ['up', 'down'], true)) {
            $classes[] = 'eead-tm-tilted';
        }
        ?>
        <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
            <?php
            $this->render_row($settings, $items, 1, $direction);
            if ($second_row) {
                $reverse = 'yes' === $settings['row2_reverse'];
                $this->render_row($settings, $items, 2, $reverse ? ('left' === $direction ? 'right' : 'left') : $direction);
            }
            ?>
        </div>
        <?php
    }

}
