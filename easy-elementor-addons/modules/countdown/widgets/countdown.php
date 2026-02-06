<?php

namespace EasyElementorAddons\Modules\Countdown\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Countdown Widget
 */
class Countdown extends Widget_Base {

    public function get_name() {
        return 'eead-countdown';
    }

    public function get_title() {
        return esc_html__('Countdown', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-count-down';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['countdown'];
    }

    public function get_style_depends() {
        return [];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_countdown_general_settings', [
                'label' => esc_html__('Timer', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'countdown_due_time', [
                'label' => esc_html__('Countdown Date & Time', 'easy-elementor-addons'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => gmdate("Y-m-d", strtotime("+ 2 day"))
            ]
        );

        $this->add_control(
            'countdown_expire_type', [
                'label' => esc_html__('Expire Type', 'easy-elementor-addons'),
                'label_block' => false,
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__('Display message or redirect to specific link on expire.', 'easy-elementor-addons'),
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'text' => esc_html__('Message', 'easy-elementor-addons'),
                    'url' => esc_html__('Redirection Link', 'easy-elementor-addons'),
                ],
                'default' => 'none'
            ]
        );

        $this->add_control(
            'countdown_expiry_text_title', [
                'label' => esc_html__('Expiry Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('On Expiry, this title will be shown in the message.', 'easy-elementor-addons'),
                'default' => esc_html__('Finished Countdown!', 'easy-elementor-addons'),
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_control(
            'countdown_expiry_text', [
                'label' => esc_html__('Expiry Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'description' => esc_html__('On Expiry, this text will be shown in the message.', 'easy-elementor-addons'),
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_control(
            'countdown_expiry_redirection', [
                'label' => esc_html__('Redirect URL', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'countdown_expire_type' => 'url',
                ],
                'default' => '#'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_countdown_content_settings', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'section_countdown_layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__('Row', 'easy-elementor-addons'),
                    'column' => esc_html__('Column', 'easy-elementor-addons'),
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-items' => 'flex-direction:{{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_alignment', [
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
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-items' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'countdown_days', [
                'label' => esc_html__('Show Days', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'countdown_days_label', [
                'label' => esc_html__('Label for Days', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Days', 'easy-elementor-addons'),
                'condition' => [
                    'countdown_days' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'countdown_hours', [
                'label' => esc_html__('Show Hours', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'countdown_hours_label', [
                'label' => esc_html__('Label for Hours', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Hours', 'easy-elementor-addons'),
                'condition' => [
                    'countdown_hours' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'countdown_minutes', [
                'label' => esc_html__('Show Minutes', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'countdown_minutes_label', [
                'label' => esc_html__('Label for Minutes', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Minutes', 'easy-elementor-addons'),
                'condition' => [
                    'countdown_minutes' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'countdown_seconds', [
                'label' => esc_html__('Show Seconds', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'countdown_seconds_label', [
                'label' => esc_html__('Label for Seconds', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Seconds', 'easy-elementor-addons'),
                'condition' => [
                    'countdown_seconds' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_countdown_styles_general', [
                'label' => esc_html__('Countdown Styles', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'countdown_background',
                'selector' => '{{WRAPPER}} .eead-countdown-item'
            ]
        );

        $this->add_responsive_control(
            'countdown_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'description' => esc_html__('Spacing between counters', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown' => '--eead-countdown-gap:{{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'countdown_box_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'countdown_box_border',
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
                'selector' => '{{WRAPPER}} .eead-countdown-item'
            ]
        );

        $this->add_responsive_control(
            'countdown_box_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'countdown_box_shadow',
                'selector' => '{{WRAPPER}} .eead-countdown-item'
            ]
        );

        $this->add_control(
            'countdown_fixed_size', [
                'label' => esc_html__('Assign Fixed Size', 'easy-elementor-addons'),
                'label' => esc_html__('Assign Fixed height and width of the counters', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'countdown_width', [
                'label' => esc_html__('Counter Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'countdown_fixed_size' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'countdown_height', [
                'label' => esc_html__('Counter Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item' => 'height:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'countdown_fixed_size' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'countdown_digits_style_settings', [
                'label' => esc_html__('Countdown Digits', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'countdown_digits_color', [
                'label' => esc_html__('Digits Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-digits' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'countdown_digit_typography',
                'selector' => '{{WRAPPER}} .eead-countdown-digits'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'countdown_label_style_settings', [
                'label' => esc_html__('Countdown Label', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'countdown_label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'countdown_label_typography',
                'selector' => '{{WRAPPER}} .eead-countdown-label'
            ]
        );

        $this->add_responsive_control(
            'countdown_label_spacing', [
                'label' => esc_html__('Label Spacing', 'easy-elementor-addons'),
                'description' => esc_html__('Spacing between counter and label', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item' => 'gap:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'separator_style_settings', [
                'label' => esc_html__('Separator', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'section_countdown_layout' => 'row',
                ]
            ]
        );

        $this->add_control(
            'countdown_separator', [
                'label' => esc_html__('Show Separator', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'countdown_separator_vertical_offset', [
                'label' => esc_html__('Vertical Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'countdown_separator' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown .eead-countdown-separator' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ]
            ]
        );

        $this->add_control(
            'countdown_separator_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'countdown_separator' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown .eead-countdown-separator' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_separator_color', [
                'label' => esc_html__('Separator Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'countdown_separator' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown .eead-countdown-separator' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'days_style_settings', [
                'label' => esc_html__('Days', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'countdown_days_background_color',
                'selector' => '{{WRAPPER}} .eead-countdown-item.eead-countdown-days'
            ]
        );

        $this->add_control(
            'countdown_days_digit_color', [
                'label' => esc_html__('Digit Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-days .eead-countdown-digits' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_days_label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-days .eead-countdown-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_days_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item.eead-countdown-days' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'hour_style_settings', [
                'label' => esc_html__('Hour', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'countdown_hours_background_color',
                'selector' => '{{WRAPPER}} .eead-countdown-item.eead-countdown-hours'
            ]
        );

        $this->add_control(
            'countdown_hours_digit_color', [
                'label' => esc_html__('Digit Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-hours .eead-countdown-digits' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_hours_label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-hours .eead-countdown-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_hours_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item.eead-countdown-hours' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'minute_style_settings', [
                'label' => esc_html__('Minute', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'countdown_minutes_background_color',
                'selector' => '{{WRAPPER}} .eead-countdown-item.eead-countdown-minutes'
            ]
        );

        $this->add_control(
            'countdown_minutes_digit_color', [
                'label' => esc_html__('Digit Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-minutes .eead-countdown-digits' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_minutes_label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-minutes .eead-countdown-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_minutes_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item.eead-countdown-minutes' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'seconds_style_settings', [
                'label' => esc_html__('Seconds', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'countdown_seconds_background_color',
                'selector' => '{{WRAPPER}} .eead-countdown-item.eead-countdown-seconds'
            ]
        );

        $this->add_control(
            'countdown_seconds_digit_color', [
                'label' => esc_html__('Digit Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-seconds .eead-countdown-digits' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_seconds_label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-seconds .eead-countdown-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'countdown_seconds_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-item.eead-countdown-seconds' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_countdown_expire_style', [
                'label' => esc_html__('Expire Message', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_responsive_control(
            'countdown_expire_message_alignment', [
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-finish-message' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'heading_countdown_expire_title', [
                'label' => esc_html__('Title Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'countdown_expire_title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-finish-message .expiry-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'countdown_expire_title_typography',
                'selector' => '{{WRAPPER}} .eead-countdown-finish-message .expiry-title',
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_responsive_control(
            'expire_title_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-finish-message .expiry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'heading_countdown_expire_message', [
                'label' => esc_html__('Content Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'countdown_expire_message_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-finish-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'countdown_expire_message_typography',
                'selector' => '.eead-countdown-finish-text',
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->add_responsive_control(
            'countdown_expire_message_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-countdown-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'countdown_expire_type' => 'text',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $get_due_date = esc_attr($settings['countdown_due_time']);
        $due_date = gmdate("M d Y G:i:s", strtotime($get_due_date));
        $separator = '';

        $this->add_render_attribute('eead-countdown', [
            'class' => 'eead-countdown',
            'data-expire-type' => $settings['countdown_expire_type'],
        ]);

        if ($settings['countdown_separator']) {
            $separator = '<span class="eead-countdown-separator">:</span>';
        }

        if ($settings['countdown_expire_type'] == 'text') {
            if (!empty($settings['countdown_expiry_text'])) {
                $this->add_render_attribute('eead-countdown', 'data-expiry-text', esc_html($settings['countdown_expiry_text']));
            }

            if (!empty($settings['countdown_expiry_text_title'])) {
                $this->add_render_attribute('eead-countdown', 'data-expiry-title', esc_html($settings['countdown_expiry_text_title']));
            }
        } elseif ($settings['countdown_expire_type'] == 'url') {
            $this->add_render_attribute('eead-countdown', 'data-redirect-url', esc_url($settings['countdown_expiry_redirection']));
        }
        ?>

        <div <?php $this->print_render_attribute_string('eead-countdown'); ?>>
            <div class="eead-countdown-items" data-date="<?php echo esc_attr($due_date); ?>">
                <?php
                if (!empty($settings['countdown_days'])) {
                    ?>
                    <div class="eead-countdown-item eead-countdown-days">
                        <span data-days class="eead-countdown-digits">00</span>
                        <?php
                        if (!empty($settings['countdown_days_label'])) {
                            ?>
                            <span class="eead-countdown-label"><?php echo esc_html($settings['countdown_days_label']); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    echo wp_kses_post($separator);
                }

                if (!empty($settings['countdown_hours'])) {
                    ?>
                    <div class="eead-countdown-item eead-countdown-hours">
                        <span data-hours class="eead-countdown-digits">00</span>
                        <?php
                        if (!empty($settings['countdown_hours_label'])) {
                            ?>
                            <span class="eead-countdown-label"><?php echo esc_html($settings['countdown_hours_label']); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    echo wp_kses_post($separator);
                }

                if (!empty($settings['countdown_minutes'])) {
                    ?>
                    <div class="eead-countdown-item eead-countdown-minutes">
                        <span data-minutes class="eead-countdown-digits">00</span>
                        <?php
                        if (!empty($settings['countdown_minutes_label'])) {
                            ?>
                            <span class="eead-countdown-label"><?php echo esc_html($settings['countdown_minutes_label']); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    echo wp_kses_post($separator);
                }

                if (!empty($settings['countdown_seconds'])) {
                    ?>
                    <div class="eead-countdown-item eead-countdown-seconds">
                        <span data-seconds class="eead-countdown-digits">00</span>
                        <?php
                        if (!empty($settings['countdown_seconds_label'])) {
                            ?>
                            <span class="eead-countdown-label"><?php echo esc_html($settings['countdown_seconds_label']); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
        <?php
    }

}
