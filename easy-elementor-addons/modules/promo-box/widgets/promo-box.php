<?php

namespace EasyElementorAddons\Modules\PromoBox\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Promo Box Widget
 */
class PromoBox extends Widget_Base {

    public function get_name() {
        return 'eead-promo-box';
    }

    public function get_title() {
        return esc_html__('Promo Box', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-promo-box';
    }

    public function get_keywords() {
        return ['promo', 'card', 'offer', 'sale', 'product card', 'call to action', 'banner', 'eead'];
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

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'default' => 'large',
                'condition' => [
                    'image[url]!' => ''
                ]
            ]
        );

        $this->add_control(
            'badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('New', 'easy-elementor-addons'),
                'description' => esc_html__('A small label above the title.', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Summer Collection', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h3',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Light linen, bright colors and easy fits, made for long days in the sun.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'price', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => '$49',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'old_price', [
                'label' => esc_html__('Old Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => '$69',
                'description' => esc_html__('Shown struck through next to the price.', 'easy-elementor-addons'),
                'condition' => [
                    'price!' => ''
                ]
            ]
        );

        $this->add_control(
            'ribbon', [
                'label' => esc_html__('Corner Ribbon', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('-30%', 'easy-elementor-addons'),
                'description' => esc_html__('A diagonal ribbon in the top corner. Leave empty to hide.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'ribbon_side', [
                'label' => esc_html__('Ribbon Corner', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'right',
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-left'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-right'],
                ],
                'prefix_class' => 'eead-promo-ribbon-',
                'condition' => [
                    'ribbon!' => ''
                ]
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Shop now', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com',
                'default' => ['url' => '#']
            ]
        );

        $this->add_control(
            'link_box', [
                'label' => esc_html__('Make the Whole Card a Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'link[url]!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Image on Top', 'easy-elementor-addons'),
                    'side' => esc_html__('Image at the Side', 'easy-elementor-addons'),
                    'cover' => esc_html__('Image as Background', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-promo-layout-'
            ]
        );

        $this->add_control(
            'image_side', [
                'label' => esc_html__('Image Side', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'left',
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-left'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-right'],
                ],
                'prefix_class' => 'eead-promo-side-',
                'condition' => [
                    'layout' => 'side'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height', [
                'label' => esc_html__('Image Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 80, 'max' => 600]],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-media' => 'height: {{SIZE}}px',
                ],
                'condition' => [
                    'layout' => 'top'
                ]
            ]
        );

        $this->add_responsive_control(
            'min_height', [
                'label' => esc_html__('Card Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 200, 'max' => 900],
                    'vh' => ['min' => 20, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'layout!' => 'top'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors_dictionary' => [
                    'left' => 'text-align: left; align-items: flex-start',
                    'center' => 'text-align: center; align-items: center',
                    'right' => 'text-align: right; align-items: flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-body' => '{{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_v_align', [
                'label' => esc_html__('Vertical Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => esc_html__('Top', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-top'],
                    'center' => ['title' => esc_html__('Middle', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-middle'],
                    'flex-end' => ['title' => esc_html__('Bottom', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-bottom'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-body' => 'justify-content: {{VALUE}}',
                ],
                'condition' => [
                    'layout!' => 'top'
                ]
            ]
        );

        $this->add_control(
            'hover_effect', [
                'label' => esc_html__('Hover Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'zoom',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'zoom' => esc_html__('Zoom Image', 'easy-elementor-addons'),
                    'lift' => esc_html__('Lift Card', 'easy-elementor-addons'),
                    'both' => esc_html__('Zoom and Lift', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-promo-hover-'
            ]
        );

        $this->end_controls_section();

        /* Style: Card */
        $this->start_controls_section(
            'section_style_card', [
                'label' => esc_html__('Card', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'card_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'overlay', [
                'label' => esc_html__('Image Overlay', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo' => '--eead-promo-overlay: {{VALUE}}',
                ],
                'condition' => [
                    'layout' => 'cover'
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding', [
                'label' => esc_html__('Content Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .eead-promo'
            ]
        );

        $this->add_responsive_control(
            'card_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .eead-promo' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .eead-promo'
            ]
        );

        $this->end_controls_section();

        /* Style: Text */
        $this->start_controls_section(
            'section_style_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-promo-title',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo .eead-promo-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'desc_typography',
                'label' => esc_html__('Description Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-promo-desc',
                'separator' => 'before',
                'condition' => [
                    'description!' => ''
                ]
            ]
        );

        $this->add_control(
            'desc_color', [
                'label' => esc_html__('Description Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-desc' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'description!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-promo-price',
                'separator' => 'before',
                'condition' => [
                    'price!' => ''
                ]
            ]
        );

        $this->add_control(
            'price_color', [
                'label' => esc_html__('Price Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-price' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'price!' => ''
                ]
            ]
        );

        $this->add_control(
            'badge_heading', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'badge!' => ''
                ]
            ]
        );

        $this->add_control(
            'badge_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-badge' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'badge!' => ''
                ]
            ]
        );

        $this->add_control(
            'badge_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'badge!' => ''
                ]
            ]
        );

        $this->add_control(
            'ribbon_heading', [
                'label' => esc_html__('Ribbon', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'ribbon!' => ''
                ]
            ]
        );

        $this->add_control(
            'ribbon_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-ribbon' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'ribbon!' => ''
                ]
            ]
        );

        $this->add_control(
            'ribbon_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-ribbon' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'ribbon!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Button */
        $this->start_controls_section(
            'section_style_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_text!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-promo-button'
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-button' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-button:hover, {{WRAPPER}} .eead-promo:hover .eead-promo-button' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-button:hover, {{WRAPPER}} .eead-promo:hover .eead-promo-button' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-promo-button' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $has_link = !empty($settings['link']['url']);
        $box_link = $has_link && 'yes' === $settings['link_box'];
        $title_tag = eead_check_allowed_html_tags($settings['title_tag'], 'h3');

        $image = '';
        if (!empty($settings['image']['id'])) {
            $image = Group_Control_Image_Size::get_attachment_image_html($settings, 'image', 'image');
        } elseif (!empty($settings['image']['url'])) {
            $image = '<img src="' . esc_url($settings['image']['url']) . '" alt="">';
        }

        $this->add_render_attribute('card', 'class', 'eead-promo');
        if ($box_link) {
            $this->add_link_attributes('card', $settings['link']);
        }
        $tag = $box_link ? 'a' : 'div';
        ?>
        <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string('card'); ?>>
            <?php if ('' !== trim((string) $settings['ribbon'])) { ?>
                <span class="eead-promo-ribbon-wrap" aria-hidden="true"><span class="eead-promo-ribbon"><?php echo esc_html($settings['ribbon']); ?></span></span>
            <?php } ?>
            <?php if ($image) { ?>
                <div class="eead-promo-media"><?php echo wp_kses_post($image); ?></div>
            <?php } ?>
            <div class="eead-promo-body">
                <?php if ('' !== $settings['badge']) { ?>
                    <span class="eead-promo-badge"><?php echo esc_html($settings['badge']); ?></span>
                <?php } ?>
                <?php if ('' !== $settings['title']) { ?>
                    <<?php echo esc_attr($title_tag); ?> class="eead-promo-title"><?php echo esc_html($settings['title']); ?></<?php echo esc_attr($title_tag); ?>>
                <?php } ?>
                <?php if ('' !== $settings['description']) { ?>
                    <div class="eead-promo-desc"><?php echo wp_kses_post(wpautop($settings['description'])); ?></div>
                <?php } ?>
                <?php if ('' !== $settings['price']) { ?>
                    <div class="eead-promo-pricing">
                        <span class="eead-promo-price"><?php echo esc_html($settings['price']); ?></span>
                        <?php if ('' !== $settings['old_price']) { ?>
                            <del class="eead-promo-old"><span class="screen-reader-text"><?php esc_html_e('Was', 'easy-elementor-addons'); ?> </span><?php echo esc_html($settings['old_price']); ?></del>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php
                if ('' !== $settings['button_text']) {
                    if ($has_link && !$box_link) {
                        $this->add_link_attributes('button', $settings['link']);
                        $this->add_render_attribute('button', 'class', 'eead-promo-button');
                        echo '<a ' . $this->get_render_attribute_string('button') . '>' . esc_html($settings['button_text']) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    } else {
                        // Inside a linked card the button is only a visual cue; links cannot nest.
                        echo '<span class="eead-promo-button">' . esc_html($settings['button_text']) . '</span>';
                    }
                }
                ?>
            </div>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }

}
