<?php

namespace EasyElementorAddons\Modules\ImageComparison\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class ImageComparison extends Widget_Base {

    public function get_name() {
        return 'eead-image-comparison';
    }

    public function get_title() {
        return esc_html__('Image Comparison', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-compare';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['image-compare'];
    }

    public function get_script_depends() {
        return ['image-compare'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content_layout', [
                'label' => esc_html__('Image', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'before_image', [
                'label' => esc_html__('Before Image', 'easy-elementor-addons'),
                'description' => esc_html__('Use same size image for before and after for better preview.', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'before_label', [
                'label' => esc_html__('Before Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Before Label', 'easy-elementor-addons'),
                'default' => esc_html__('Before', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'after_image', [
                'label' => esc_html__('After Image', 'easy-elementor-addons'),
                'description' => esc_html__('Use same size image for before and after for better preview.', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'after_label', [
                'label' => esc_html__('After Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('After Label', 'easy-elementor-addons'),
                'default' => esc_html__('After', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail_size',
                'label' => esc_html__('Image Size', 'easy-elementor-addons'),
                'exclude' => ['custom'],
                'default' => 'full'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_additional_settings', [
                'label' => esc_html__('Additional', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'orientation', [
                'label' => esc_html__('Orientation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'easy-elementor-addons'),
                    'vertical' => esc_html__('Vertical', 'easy-elementor-addons'),
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'starting_point', [
                'label' => esc_html__('Slider Starting Point(%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                        'min' => 1,
                    ],
                ]
            ]
        );

        $this->add_control(
            'move_slider_on', [
                'label' => esc_html__('Move Slider On', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'drag',
                'options' => [
                    'drag' => esc_html__('Drag', 'easy-elementor-addons'),
                    'hover' => esc_html__('Hover', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'smoothing', [
                'label' => esc_html__('Enable Smoothing', 'easy-elementor-addons'),
                'description' => esc_html__('Smooth Movement of the Slider Handle', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'smoothing_intensity', [
                'label' => esc_html__('Smoothing Intensity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                ],
                'range' => [
                    'px' => [
                        'max' => 1000,
                        'min' => 100,
                        'step' => 10,
                    ]
                ],
                'condition' => [
                    'smoothing' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_before_after_label', [
                'label' => esc_html__('Show Before/After Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'no' => esc_html__('No', 'easy-elementor-addons'),
                    'yes' => esc_html__('Yes', 'easy-elementor-addons'),
                    'hover' => esc_html__('On Hover', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_overlay', [
                'label' => esc_html__('Show Overlay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'add_circle', [
                'label' => esc_html__('Show Circle on Slider Handle', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'add_circle_blur', [
                'label' => esc_html__('Enable Circle Blur', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'add_circle' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'add_circle_shadow', [
                'label' => esc_html__('Enable Circle Shadow', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'add_circle' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style', [
                'label' => esc_html__('General Style', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'overlay_color', [
                'label' => esc_html__('Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-comparison .eead-image-compare-overlay:before' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'show_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'bar_color', [
                'label' => esc_html__('Bar Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffff'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'before_after_style', [
                'label' => esc_html__('Before & After Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'after_before_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-image-compare .icv__label'
            ]
        );

        $this->add_responsive_control(
            'after_before_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'after_before_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_image_compare_style');

        $this->start_controls_tab(
            'tab_image_compare_before_style', [
                'label' => esc_html__('Before', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'before_background', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label.icv__label-before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'before_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label.icv__label-before' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_compare_after_style', [
                'label' => esc_html__('After', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'after_background', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label.icv__label-after' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'after_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-compare .icv__label.icv__label-after' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $compare_settings = [
            'id' => esc_attr('eead-image-compare-' . $id),
            'orientation' => $settings['orientation'] == 'horizontal' ? false : true,
            'smoothing' => $settings['smoothing'] == 'yes' ? true : false,
            'smoothing_amount' => $settings['smoothing_intensity']['size'] ? $settings['smoothing_intensity']['size'] : 600,
            'before_label' => $settings['before_label'] ? $settings['before_label'] : false,
            'after_label' => $settings['after_label'] ? $settings['after_label'] : false,
            'show_before_after_label' => ($settings['show_before_after_label'] == 'yes' || $settings['show_before_after_label'] == 'hover') ? true : false,
            'show_before_after_label_onhover' => $settings['show_before_after_label'] == 'hover' ? true : false,
            'move_slider_on_hover' => $settings['move_slider_on'] == 'hover' ? true : false,
            'starting_point' => $settings['starting_point']['size'] ? $settings['starting_point']['size'] : 50,
            'add_circle' => $settings['add_circle'] == 'yes' ? true : false,
            'add_circle_blur' => $settings['add_circle_blur'] == 'yes' ? true : false,
            'add_circle_shadow' => $settings['add_circle_shadow'] == 'yes' ? true : false,
            'bar_color' => $settings['bar_color'] ? $settings['bar_color'] : false,
            'show_overlay' => $settings['show_overlay'] == 'yes' ? true : false
        ];

        $this->add_render_attribute([
            'image-compare' => [
                'id' => esc_attr('eead-image-compare-' . $id),
                'class' => ['eead-image-compare'],
                'data-settings' => [
                    wp_json_encode($compare_settings),
                ]
            ],
        ]);

        if ($settings['show_overlay'] == 'yes') {
            $this->add_render_attribute('image-compare', 'class', 'eead-image-compare-overlay');
        }
        ?>
        <div class="eead-image-comparison">
            <div <?php $this->print_render_attribute_string('image-compare'); ?>>
                <?php
                echo Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail_size', 'before_image');
                echo Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail_size', 'after_image');
                ?>
            </div>
        </div>
        <?php
    }

}
