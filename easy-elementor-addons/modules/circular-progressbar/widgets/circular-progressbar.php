<?php

namespace EasyElementorAddons\Modules\CircularProgressbar\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Circular Progressbar Widget
 */
class CircularProgressbar extends Widget_Base {

    public function get_name() {
        return 'eead-circular-progressbar';
    }

    public function get_title() {
        return esc_html__('Circular Progressbar', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-circular-bar';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['waypoint'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Circular Progressbar', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'progressbar_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Progress', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'progressbar_percentage', [
                'label' => esc_html__('Percentage', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 90,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'circle_size', [
                'label' => esc_html__('Circle Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 700,
                        'step' => 1,
                    ]
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar' => '--eead-cb-circle-size: {{SIZE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'circle_stroke', [
                'label' => esc_html__('Circle Bar Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar' => '--eead-cb-circle-stroke: {{SIZE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar-box .eead-cb-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-circular-progressbar-box .eead-cb-title'
            ]
        );

        $this->add_control(
            'title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar-box .eead-cb-title' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'percent_style', [
                'label' => esc_html__('Percent', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'percent_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar-box .eead-cb-number' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'percent_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-circular-progressbar-box .eead-cb-number'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'progressbar_style', [
                'label' => esc_html__('Progress Bar', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'progressbar_text_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar-box svg circle:nth-child(1)' => 'stroke: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'progress_indication_color', [
                'label' => esc_html__('Progress Indication Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar-box svg circle:nth-child(2)' => 'stroke: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $radius = isset($settings['circle_size']['size']) ? intval($settings['circle_size']['size']) : 200;
        $stroke_width = isset($settings['circle_stroke']['size']) ? intval($settings['circle_stroke']['size']) : 10;
        $circle_size = $radius + $stroke_width / 2;
        $dasharray = 2 * 3.14 * $radius;
        $svg_size = $radius * 2 + $stroke_width;
        ?>
        <div class="eead-circular-progressbar" data-number="<?php echo esc_attr($settings['progressbar_percentage']['size']); ?>" data-radius="<?php echo esc_attr($radius); ?>">
            <div class="eead-circular-progressbar-box">
                <div class="eead-cb-percent">
                    <svg style="height:<?php echo esc_attr($svg_size); ?>px;width:<?php echo esc_attr($svg_size); ?>px">
                        <circle fill="none" cx="<?php echo esc_attr($circle_size); ?>" cy="<?php echo esc_attr($circle_size); ?>" r="<?php
                              echo esc_attr($radius);
                              ?>" stroke-width="<?php echo esc_attr($stroke_width); ?>"></circle>
                        <circle fill="none" cx="<?php echo esc_attr($circle_size); ?>" cy="<?php echo esc_attr($circle_size); ?>" r="<?php
                              echo esc_attr($radius);
                              ?>" stroke-dasharray="<?php echo esc_attr($dasharray); ?>" stroke-dashoffset="<?php echo esc_attr($dasharray); ?>" stroke-width="<?php echo esc_attr($stroke_width); ?>"></circle>
                    </svg>

                    <div class="eead-cb-number">
                        <?php echo esc_html($settings['progressbar_percentage']['size']); ?>%
                    </div>
                </div>

                <h4 class="eead-cb-title">
                    <?php echo esc_html($settings['progressbar_title']); ?>
                </h4>
            </div>
        </div>
        <?php
    }

}
