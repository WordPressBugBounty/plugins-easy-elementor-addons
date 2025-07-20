<?php

namespace EasyElementorAddons\Modules\Counter\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Counter Widget
 */
class Counter extends Widget_Base {

    public function get_name() {
        return 'eead-counter';
    }

    public function get_title() {
        return esc_html__('Counter', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-counter';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['waypoint', 'odometer'];
    }

    public function get_style_depends() {
        return ['odometer-theme-default'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'counter', [
                'label' => esc_html__('Counter', 'easy-elementor-addons')
            ]
        );


        $this->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ]
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Title', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'count', [
                'label' => esc_html__('Count Value (Number Only)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5500
            ]
        );

        $this->add_control(
            'starting_value', [
                'label' => esc_html__('Starting Value (Number Only)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1
            ]
        );

        $this->add_control(
            'pre_text', [
                'label' => esc_html__('Pre Text', 'easy-elementor-addons'),
                'description' => esc_html__('Appears before number', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'post_text', [
                'label' => esc_html__('Post Text', 'easy-elementor-addons'),
                'description' => esc_html__('Appears after number', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $this->add_control(
            'pre_post_text_spacing', [
                'label' => esc_html__('Pre/Post Text Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-count' => 'gap: {{SIZE}}px'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'additional_settings', [
                'label' => esc_html__('Additional Settings', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'counter_style', [
                'label' => esc_html__('Counter Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style2',
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'style4' => esc_html__('Style 4', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'counter_comma', [
                'label' => esc_html__('Show Comma Notation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style', [
                'label' => esc_html__('Box Styles', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'counter_bg',
                'selector' => '{{WRAPPER}} .eead-counter'
            ]
        );

        $this->add_control(
            'box_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box' => '--eead-counter-border-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box' => '--eead-counter-border-width: {{SIZE}}px'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .eead-counter-box .eead-counter',
                'condition' => [
                    'counter_style' => ['style3', 'style4']
                ]
            ]
        );

        $this->add_responsive_control(
            'border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'box_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-counter-box .eead-counter-icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'icon_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box.eadd-counter-style2 .eead-counter-icon:after' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'counter_style' => 'style2'
                ]
            ]
        );

        $this->add_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box.eead-counter-style4 .eead-counter' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'counter_style' => 'style4'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'counter_number_style', [
                'label' => esc_html__('Number Count', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'counter_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-count' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'counter_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-counter-box .eead-counter-count'
            ]
        );

        $this->add_control(
            'counter_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-count' => 'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ]
            ]
        );

        $this->start_controls_tabs(
            'counter_pre_post_tabs'
        );

        $this->start_controls_tab(
            'counter_pre_tab', [
                'label' => esc_html__('Pre Text', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'pre_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-pre-text' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'pre_text_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-counter-box .eead-counter-pre-text'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'counter_post_tab', [
                'label' => esc_html__('Post Text', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'post_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-post-text' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'post_text_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-counter-box .eead-counter-post-text'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'counter_title_style', [
                'label' => esc_html__('Counter Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'counter_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eead-counter-box .eead-counter-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'counter_title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-counter-box .eead-counter-title'
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $counter_style = $settings['counter_style'];
        $counter_comma = isset($settings['counter_comma']) && $settings['counter_comma'] == 'yes' ? 'yes' : 'no';
        $counter_class = array(
            'eead-counter-' . $counter_style,
            'eead-counter-box'
        );
        ?>
        <div class="<?php echo esc_attr(implode(' ', $counter_class)); ?>">
            <?php
            $counter_title = $settings['title'];
            $counter_count = $settings['count'];

            if ($counter_count) {
                ?>
                <div class="eead-counter">
                    <?php if ($settings['icon']['value']) { ?>
                        <div class="eead-counter-icon">
                            <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php } ?>

                    <?php
                    if ($counter_style == 'style4') {
                        echo '<div class="eead-counter-block">';
                    }
                    ?>

                    <div class="eead-counter-count">
                        <?php if (trim($settings['pre_text'])) { ?>
                            <span class="eead-counter-pre-text">
                                <?php echo esc_html($settings['pre_text']); ?>
                            </span>
                        <?php } ?>

                        <span class="eead-odometer" data-count="<?php echo $counter_count; ?>" data-start="<?php echo $settings['starting_value']; ?>" data-comma="<?php echo $counter_comma; ?>">
                            <?php echo esc_html($settings['starting_value']); ?>
                        </span>

                        <?php if (trim($settings['post_text'])) { ?>
                            <span class="eead-counter-post-text">
                                <?php echo esc_html($settings['post_text']); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <h4 class="eead-counter-title">
                        <?php echo esc_html($counter_title); ?>
                    </h4>
                    <?php
                    if ($counter_style == 'style4') {
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}
