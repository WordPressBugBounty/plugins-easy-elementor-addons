<?php

namespace EasyElementorAddons\Modules\AppearingImage\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Appearing Image Widget
 */
class AppearingImage extends Widget_Base {

    public function get_name() {
        return 'eead-appearing-image';
    }

    public function get_title() {
        return esc_html__('Appearing Image', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-appearing-image';
    }

    public function get_keywords() {
        return ['image reveal', 'appearing image', 'scroll animation', 'wipe', 'curtain', 'eead'];
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
            'section_image', [
                'label' => esc_html__('Image', 'easy-elementor-addons')
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
                'default' => 'large'
            ]
        );

        $this->add_control(
            'caption', [
                'label' => esc_html__('Caption', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_reveal', [
                'label' => esc_html__('Reveal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'effect', [
                'label' => esc_html__('Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'wipe-left',
                'options' => [
                    'wipe-left' => esc_html__('Wipe From Left', 'easy-elementor-addons'),
                    'wipe-right' => esc_html__('Wipe From Right', 'easy-elementor-addons'),
                    'wipe-up' => esc_html__('Wipe From Bottom', 'easy-elementor-addons'),
                    'wipe-down' => esc_html__('Wipe From Top', 'easy-elementor-addons'),
                    'curtain' => esc_html__('Color Curtain', 'easy-elementor-addons'),
                    'circle' => esc_html__('Circle', 'easy-elementor-addons'),
                    'zoom' => esc_html__('Zoom Out', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-apim-effect-'
            ]
        );

        $this->add_control(
            'trigger', [
                'label' => esc_html__('Play', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'view',
                'options' => [
                    'view' => esc_html__('Once, When in View', 'easy-elementor-addons'),
                    'scroll' => esc_html__('With the Scroll', 'easy-elementor-addons'),
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'duration', [
                'label' => esc_html__('Duration (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 200, 'max' => 4000, 'step' => 50]],
                'default' => ['size' => 1200],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim' => '--eead-apim-duration: {{SIZE}}ms',
                ],
                'condition' => [
                    'trigger' => 'view'
                ]
            ]
        );

        $this->add_control(
            'delay', [
                'label' => esc_html__('Delay (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 3000, 'step' => 50]],
                'default' => ['size' => 0],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim' => '--eead-apim-delay: {{SIZE}}ms',
                ],
                'condition' => [
                    'trigger' => 'view'
                ]
            ]
        );

        $this->add_control(
            'start', [
                'label' => esc_html__('Start When It Reaches (% of screen)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 100]],
                'default' => ['size' => 95],
                'render_type' => 'template',
                'condition' => [
                    'trigger' => 'scroll'
                ]
            ]
        );

        $this->add_control(
            'end', [
                'label' => esc_html__('Finish When It Reaches (% of screen)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 100]],
                'default' => ['size' => 45],
                'render_type' => 'template',
                'condition' => [
                    'trigger' => 'scroll'
                ]
            ]
        );

        $this->add_control(
            'curtain_color', [
                'label' => esc_html__('Curtain Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#6D28D9',
                'selectors' => [
                    '{{WRAPPER}} .eead-apim' => '--eead-apim-curtain: {{VALUE}}',
                ],
                'condition' => [
                    'effect' => 'curtain'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style */
        $this->start_controls_section(
            'section_style', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => 10, 'max' => 100],
                    'px' => ['min' => 50, 'max' => 1600],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim-figure' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'ratio', [
                'label' => esc_html__('Shape', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Original', 'easy-elementor-addons'),
                    '1/1' => esc_html__('Square (1:1)', 'easy-elementor-addons'),
                    '4/3' => esc_html__('Landscape (4:3)', 'easy-elementor-addons'),
                    '16/9' => esc_html__('Wide (16:9)', 'easy-elementor-addons'),
                    '21/9' => esc_html__('Cinema (21:9)', 'easy-elementor-addons'),
                    '3/4' => esc_html__('Portrait (3:4)', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim-frame img' => 'aspect-ratio: {{VALUE}}; object-fit: cover',
                ]
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'flex-end' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 80]],
                'selectors' => [
                    '{{WRAPPER}} .eead-apim-frame' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'shadow',
                'selector' => '{{WRAPPER}} .eead-apim-frame'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'caption_typography',
                'label' => esc_html__('Caption Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-apim-caption',
                'separator' => 'before',
                'condition' => [
                    'caption!' => ''
                ]
            ]
        );

        $this->add_control(
            'caption_color', [
                'label' => esc_html__('Caption Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-apim-caption' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'caption!' => ''
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['image']['id'])) {
            $image = Group_Control_Image_Size::get_attachment_image_html($settings, 'image', 'image');
        } elseif (!empty($settings['image']['url'])) {
            $image = '<img src="' . esc_url($settings['image']['url']) . '" alt="">';
        } else {
            return;
        }

        $this->add_render_attribute('wrap', [
            'class' => 'eead-apim',
            'data-settings' => wp_json_encode([
                'trigger' => 'scroll' === $settings['trigger'] ? 'scroll' : 'view',
                'start' => isset($settings['start']['size']) ? (float) $settings['start']['size'] : 95,
                'end' => isset($settings['end']['size']) ? (float) $settings['end']['size'] : 45,
            ]),
        ]);

        $has_link = !empty($settings['link']['url']);
        if ($has_link) {
            $this->add_link_attributes('link', $settings['link']);
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrap'); ?>>
            <figure class="eead-apim-figure">
                <?php if ($has_link) { ?>
                    <a <?php $this->print_render_attribute_string('link'); ?>>
                <?php } ?>
                <span class="eead-apim-frame"><?php echo wp_kses_post($image); ?></span>
                <?php if ($has_link) { ?>
                    </a>
                <?php } ?>
                <?php if ('' !== $settings['caption']) { ?>
                    <figcaption class="eead-apim-caption"><?php echo esc_html($settings['caption']); ?></figcaption>
                <?php } ?>
            </figure>
        </div>
        <?php
    }

}
