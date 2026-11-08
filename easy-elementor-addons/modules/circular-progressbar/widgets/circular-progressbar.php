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

    public function get_keywords() {
        return ['circular progress', 'progress', 'circle', 'skill', 'eead'];
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

        $this->add_control(
            'number_suffix', [
                'label' => esc_html__('Number Suffix', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '%',
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h4',
            ]
        );

        $this->add_control(
            'start_position', [
                'label' => esc_html__('Start Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'top' => esc_html__('Top (12 o\'clock)', 'easy-elementor-addons'),
                    'right' => esc_html__('Right (3 o\'clock)', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom (6 o\'clock)', 'easy-elementor-addons'),
                    'left' => esc_html__('Left (9 o\'clock)', 'easy-elementor-addons'),
                ],
                'selectors_dictionary' => [
                    'top' => '-90deg',
                    'right' => '0deg',
                    'bottom' => '90deg',
                    'left' => '180deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar svg' => 'transform: rotate({{VALUE}});',
                ]
            ]
        );

        $this->add_control(
            // Not 'animation_duration': Elementor's Motion Effects control already uses that name on every widget.
            'cpb_animation_duration', [
                'label' => esc_html__('Animation Duration (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 5000, 'step' => 100]],
                'default' => ['size' => 1000],
                'selectors' => [
                    '{{WRAPPER}} .eead-circular-progressbar' => '--eead-cb-duration: {{SIZE}}ms;',
                ]
            ]
        );

        $this->add_control(
            'count_up', [
                'label' => esc_html__('Count Up Number', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $percent = isset($settings['progressbar_percentage']['size']) && is_numeric($settings['progressbar_percentage']['size']) ? max(0, min(100, (float) $settings['progressbar_percentage']['size'])) : 0;
        $radius = !empty($settings['circle_size']['size']) ? intval($settings['circle_size']['size']) : 80;
        $stroke_width = !empty($settings['circle_stroke']['size']) ? intval($settings['circle_stroke']['size']) : 10;
        $center = $radius + $stroke_width / 2;
        $svg_size = $radius * 2 + $stroke_width;
        $suffix = isset($settings['number_suffix']) ? $settings['number_suffix'] : '%';
        $title = trim((string) $settings['progressbar_title']);

        $this->add_render_attribute('bar', [
            'class' => ['eead-circular-progressbar', $percent <= 0 ? 'eead-cb-empty' : ''],
            'data-number' => $percent,
            'data-count' => 'yes' === $settings['count_up'] ? 'yes' : 'no',
            'role' => 'progressbar',
            'aria-valuemin' => 0,
            'aria-valuemax' => 100,
            'aria-valuenow' => $percent,
        ]);
        if ($title !== '') {
            $this->add_render_attribute('bar', 'aria-label', $title);
        }
        /*
         * pathLength="100" makes the dash maths a plain percentage whatever the
         * radius, and the geometry also comes from CSS variables, so the
         * tablet/mobile Circle Size and Bar Width really resize the ring. The
         * attributes are the desktop fallback.
         */
        ?>
        <div <?php $this->print_render_attribute_string('bar'); ?>>
            <div class="eead-circular-progressbar-box">
                <div class="eead-cb-percent">
                    <svg aria-hidden="true" focusable="false" width="<?php echo esc_attr($svg_size); ?>" height="<?php echo esc_attr($svg_size); ?>">
                        <circle fill="none" cx="<?php echo esc_attr($center); ?>" cy="<?php echo esc_attr($center); ?>" r="<?php echo esc_attr($radius); ?>" stroke-width="<?php echo esc_attr($stroke_width); ?>"></circle>
                        <circle fill="none" cx="<?php echo esc_attr($center); ?>" cy="<?php echo esc_attr($center); ?>" r="<?php echo esc_attr($radius); ?>" pathLength="100" stroke-dasharray="100" stroke-dashoffset="100" stroke-width="<?php echo esc_attr($stroke_width); ?>"></circle>
                    </svg>

                    <div class="eead-cb-number" aria-hidden="true"><span class="eead-cb-value"><?php echo esc_html($percent + 0); ?></span><?php echo esc_html($suffix); ?></div>
                </div>

                <?php if ($title !== '') { ?>
                    <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'], 'h4')); ?> class="eead-cb-title"><?php echo esc_html($title); ?></<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'], 'h4')); ?>>
                <?php } ?>
            </div>
        </div>
        <?php
    }

}
