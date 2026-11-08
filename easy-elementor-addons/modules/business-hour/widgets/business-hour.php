<?php

namespace EasyElementorAddons\Modules\BusinessHour\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use DateTime;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Business Hour Widget
 */
class BusinessHour extends Widget_Base {

    public function get_name() {
        return 'eead-business-hour';
    }

    public function get_title() {
        return esc_html__('Business Hour', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-business-hours';
    }

    public function get_keywords() {
        return ['business hours', 'opening hours', 'schedule', 'time', 'eead'];
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
        return ['jclock'];
    }

    protected function register_controls() {
        $time_24hr = false;
        $wp_time_format = get_option('time_format');
        if ((strpos($wp_time_format, 'G') !== false) or (strpos($wp_time_format, 'H') !== false)) {
            $time_24hr = true;
        }

        $this->start_controls_section(
            'header_content', [
                'label' => esc_html__('Header Contents', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'header_content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-close',
                    ],
                    'date' => [
                        'title' => esc_html__('Todays Date', 'easy-elementor-addons'),
                        'icon' => 'eicon-calendar',
                    ],
                    'status' => [
                        'title' => esc_html__('Open Status', 'easy-elementor-addons'),
                        'icon' => 'eicon-info',
                    ],
                    'text' => [
                        'title' => esc_html__('Custom Message', 'easy-elementor-addons'),
                        'icon' => 'eicon-animated-headline',
                    ]
                ],
                'default' => 'date',
            ]
        );

        $this->add_control(
            'header_open_msg', [
                'label' => esc_html__('Open Message', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('We are open.', 'easy-elementor-addons'),
                'placeholder' => esc_html__('We are open.', 'easy-elementor-addons'),
                'condition' => [
                    'header_content_type' => 'status'
                ],
            ]
        );

        $this->add_control(
            'header_closed_msg', [
                'label' => esc_html__('Closed Message', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Sorry, We are currently closed.', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Sorry, We are closed.', 'easy-elementor-addons'),
                'condition' => [
                    'header_content_type' => 'status'
                ],
            ]
        );

        // Custom Message
        $this->add_control(
            'header_text', [
                'label' => esc_html__('Custom Message', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Your Custom Message', 'easy-elementor-addons'),
                'condition' => [
                    'header_content_type' => 'text'
                ],
            ]
        );

        $this->add_responsive_control(
            'header_content_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'center' => esc_html__('Center', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons')
                ],
                'default' => 'left',
                'condition' => [
                    'header_content_type!' => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-header' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'business_hours', [
                'label' => esc_html__('Business Hours', 'easy-elementor-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'start_time', [
                'label' => esc_html__('Start Time', 'easy-elementor-addons'),
                'label_block' => false,
                'type' => Controls_Manager::DATE_TIME,
                'default' => $this->format_time('9:00'), //'H:i'
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => $this->time_format_to_js($wp_time_format),
                    'time_24hr' => $time_24hr
                ]
            ]
        );

        $repeater->add_control(
            'end_time', [
                'label' => esc_html__('End Time', 'easy-elementor-addons'),
                'label_block' => false,
                'type' => Controls_Manager::DATE_TIME,
                'default' => $this->format_time('18:00'), //'H:i'
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => $this->time_format_to_js($wp_time_format),
                    'time_24hr' => $time_24hr
                ]
            ]
        );

        /** Days of week. */
        $week = [
            'sun' => esc_html__('Sunday', 'easy-elementor-addons'),
            'mon' => esc_html__('Monday', 'easy-elementor-addons'),
            'tue' => esc_html__('Tuesday', 'easy-elementor-addons'),
            'wed' => esc_html__('Wednesday', 'easy-elementor-addons'),
            'thu' => esc_html__('Thursday', 'easy-elementor-addons'),
            'fri' => esc_html__('Friday', 'easy-elementor-addons'),
            'sat' => esc_html__('Saturday', 'easy-elementor-addons'),
        ];

        /** Add array offset, to set correct first day of week. */
        $week = $this->set_start_of_week($week);

        /** Create control foreach day of week. */
        foreach ($week as $key => $day) {
            /** Header. */
            $this->add_control(
                "{$key}_header", [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<h4><strong>' . $day . '</strong></h4>',
                ]
            );

            /** Day Label. */
            $this->add_control(
                "{$key}day_label", [
                    'label' => esc_html__('Day Label:', 'easy-elementor-addons'),
                    'label_block' => false,
                    'type' => Controls_Manager::TEXT,
                    'default' => $day,
                ]
            );

            /** Closed: weekends by default, wherever the week starts. */
            $default = in_array($key, ['sat', 'sun'], true) ? 'yes' : '';
            $this->add_control(
                "{$key}_closed", [
                    'label' => esc_html__('Closed All Day:', 'easy-elementor-addons'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => $default,
                ]
            );

            $this->add_control(
                "{$key}_closed_day_msg", [
                    'label' => esc_html__('Closed All Day Message:', 'easy-elementor-addons'),
                    'label_block' => true,
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Closed All Day', 'easy-elementor-addons'),
                    'placeholder' => esc_html__('Closed All Day', 'easy-elementor-addons'),
                    'condition' => [
                        "{$key}_closed" => 'yes'
                    ]
                ]
            );

            /** Business Hours. */
            $this->add_control(
                "{$key}_business_hours", [
                    'label' => esc_html__('Business Hours:', 'easy-elementor-addons'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'prevent_empty' => false,
                    'default' => [
                        [
                            'start_time' => $this->format_time('9:00'), //'H:i',
                            'end_time' => $this->format_time('20:00'), //'H:i'
                        ]
                    ],
                    'title_field' => '{{ start_time }} - {{ end_time }}',
                    'description' => esc_html__('An end time earlier than the start time runs past midnight, e.g. 6:00 pm - 2:00 am.', 'easy-elementor-addons'),
                    'condition' => [
                        "{$key}_closed" => '',
                    ],
                ]
            );

            /** Separator. */
            $this->add_control("{$key}_separator", ['type' => Controls_Manager::DIVIDER, 'style' => 'thick']);
        } // End Foreach.

        $this->end_controls_section();

        $this->start_controls_section(
            'footer_content', [
                'label' => esc_html__('Footer Contents', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'footer_content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'none' => [
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-close',
                    ],
                    'date' => [
                        'title' => esc_html__('Todays Date', 'easy-elementor-addons'),
                        'icon' => 'eicon-calendar',
                    ],
                    'status' => [
                        'title' => esc_html__('Open Status', 'easy-elementor-addons'),
                        'icon' => 'eicon-info',
                    ],
                    'text' => [
                        'title' => esc_html__('Custom Message', 'easy-elementor-addons'),
                        'icon' => 'eicon-animated-headline',
                    ]
                ],
                'default' => 'status',
            ]
        );

        $this->add_control(
            'footer_open_msg', [
                'label' => esc_html__('Open Message', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('We are open.', 'easy-elementor-addons'),
                'placeholder' => esc_html__('We are open.', 'easy-elementor-addons'),
                'condition' => [
                    'footer_content_type' => 'status'
                ],
            ]
        );

        $this->add_control(
            'footer_closed_msg', [
                'label' => esc_html__('Closed Message', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Sorry, We are currently closed.', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Sorry, We are closed.', 'easy-elementor-addons'),
                'condition' => [
                    'footer_content_type' => 'status'
                ],
            ]
        );

        // Custom Message
        $this->add_control(
            'footer_text', [
                'label' => esc_html__('Custom Message', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Your Custom Message', 'easy-elementor-addons'),
                'condition' => [
                    'footer_content_type' => 'text'
                ],
            ]
        );

        $this->add_responsive_control(
            'footer_content_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'center' => esc_html__('Center', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons')
                ],
                'default' => 'left',
                'condition' => [
                    'footer_content_type!' => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-footer' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'time_zone', [
                'label' => esc_html__('Time Zone', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'business_hour_style', [
                'label' => esc_html__('Display Timer', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('No', 'easy-elementor-addons'),
                    'dynamic' => esc_html__('Yes', 'easy-elementor-addons')
                ],
                'default' => 'default',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'header_content_type',
                            'operator' => '==',
                            'value' => 'date',
                        ],
                        [
                            'name' => 'footer_content_type',
                            'operator' => '==',
                            'value' => 'date',
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'dynamic_timezone', [
                'label' => esc_html__('Timezone', 'easy-elementor-addons'),
                'description' => esc_html__('Used for the clock, the open/closed status and the highlighted day.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => 'Website Time',
                    '-0' => esc_html__('UT or UTC - GMT -0', 'easy-elementor-addons'),
                    '+1' => esc_html__('CET - GMT+1', 'easy-elementor-addons'),
                    '+2' => esc_html__('EET - GMT+2', 'easy-elementor-addons'),
                    '+3' => esc_html__('MSK - GMT+3', 'easy-elementor-addons'),
                    '+4' => esc_html__('SMT - GMT+4', 'easy-elementor-addons'),
                    '+5' => esc_html__('PKT - GMT+5', 'easy-elementor-addons'),
                    '+5.5' => esc_html__('IND - GMT+5.5', 'easy-elementor-addons'),
                    '+6' => esc_html__('OMSK / BD - GMT+6', 'easy-elementor-addons'),
                    '+7' => esc_html__('CXT - GMT+7', 'easy-elementor-addons'),
                    '+8' => esc_html__('CST / AWST / WST - GMT+8', 'easy-elementor-addons'),
                    '+9' => esc_html__('JST - GMT+9', 'easy-elementor-addons'),
                    '+10' => esc_html__('EAST - GMT+10', 'easy-elementor-addons'),
                    '+11' => esc_html__('SAKT - GMT+11', 'easy-elementor-addons'),
                    '+12' => esc_html__('IDLE  - GMT+12', 'easy-elementor-addons'),
                    '+13' => esc_html__('NZDT  - GMT+13', 'easy-elementor-addons'),
                    '-1' => esc_html__('WAT  - GMT-1', 'easy-elementor-addons'),
                    '-2' => esc_html__('AT  - GMT-2', 'easy-elementor-addons'),
                    '-3' => esc_html__('ART  - GMT-3', 'easy-elementor-addons'),
                    '-4' => esc_html__('AST  - GMT-4', 'easy-elementor-addons'),
                    '-5' => esc_html__('EST  - GMT-5', 'easy-elementor-addons'),
                    '-6' => esc_html__('CST  - GMT-6', 'easy-elementor-addons'),
                    '-7' => esc_html__('MST  - GMT-7', 'easy-elementor-addons'),
                    '-8' => esc_html__('PST  - GMT-8', 'easy-elementor-addons'),
                    '-9' => esc_html__('AKST  - GMT-9', 'easy-elementor-addons'),
                    '-10' => esc_html__('HST  - GMT-10', 'easy-elementor-addons'),
                    '-11' => esc_html__('NT  - GMT-11', 'easy-elementor-addons'),
                    '-12' => esc_html__('IDLW  - GMT-12', 'easy-elementor-addons'),
                    'custom' => "Custom"
                ],
            ]
        );

        $this->add_control(
            'custom_timezone_input', [
                'label' => esc_html__('Custom Timezone', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '+6',
                'placeholder' => '+6',
                'condition' => [
                    'dynamic_timezone' => 'custom'
                ]
            ]
        );

        $this->end_controls_section();

        /*  Style Tabs  */
        $this->start_controls_section(
            'header_style', [
                'label' => esc_html__('Header Section', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'header_content_type!' => 'none'
                ],
            ]
        );

        $this->add_control(
            'header_bg_color', [
                'label' => esc_html__('Header Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-header' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'header_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-header' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'header_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-business-hour .eead-bh-header',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'time_typography',
                'label' => esc_html__('Time Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-business-hour .eead-bh-current-time',
                'condition' => [
                    'header_content_type' => 'date'
                ]
            ]
        );

        $this->add_responsive_control(
            'header_padding', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /*  Style Tabs  */
        $this->start_controls_section(
            'footer_style', [
                'label' => esc_html__('Footer Section', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'footer_content_type!' => 'none'
                ],
            ]
        );

        $this->add_control(
            'footer_bg_color', [
                'label' => esc_html__('Footer Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-footer' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'footer_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-footer' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'footer_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-business-hour .eead-bh-footer',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'footer_time_typography',
                'label' => esc_html__('Time Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-business-hour .eead-bh-current-time',
                'condition' => [
                    'footer_content_type' => 'date'
                ]
            ]
        );

        $this->add_responsive_control(
            'footer_padding', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-bh-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        //Business Hour Styles
        $this->start_controls_section(
            'work_hour_style', [
                'label' => esc_html__('Business Hours', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'work_hour_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-business-hour .eead-business-hour-details',
            ]
        );

        $this->add_control(
            'work_day_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-details' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'work_day_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-details' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'current_day_bg_color', [
                'label' => esc_html__('Current Day Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-details .eead-business-hour-row.active-day' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'current_day_text_color', [
                'label' => esc_html__('Current Day Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-details .eead-business-hour-row.active-day' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'business_hours_day_align', [
                'label' => esc_html__('Day Alignment', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-business-hour .eead-business-day' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'business_hours_time_align', [
                'label' => esc_html__('Time Alignment', 'easy-elementor-addons'),
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
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-time' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'day_width', [
                'label' => esc_html__('Day Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'step' => 1,
                        'max' => 600,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-day' => 'flex-basis:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-business-hour .eead-business-time' => 'flex-basis:calc(100% - {{SIZE}}{{UNIT}});'
                ],
            ]
        );

        $this->add_responsive_control(
            'work_day_padding', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'divider_style', [
                'label' => esc_html__('Divider', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'day_divider', [
                'label' => esc_html__('Divider', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'day_divider_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'easy-elementor-addons'),
                    'dotted' => esc_html__('Dotted', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons')
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row:not(:first-child)' => 'border-top-style: {{VALUE}};'
                ],
                'condition' => [
                    'day_divider' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'day_divider_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row:not(:first-child)' => 'border-top-color: {{VALUE}};'
                ],
                'condition' => [
                    'day_divider' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'day_divider_weight', [
                'label' => esc_html__('Weight', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'day_divider' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'stripped_style', [
                'label' => esc_html__('Striped Rows', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'business_hours_striped', [
                'label' => esc_html__('Enable Striped', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'business_hours_striped_odd_color', [
                'label' => esc_html__('Striped Odd Rows Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row:nth-child(odd)' => 'background: {{VALUE}};'
                ],
                'condition' => [
                    'business_hours_striped' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'striped_effect_even', [
                'label' => esc_html__('Striped Even Rows Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-business-hour .eead-business-hour-row:nth-child(even)' => 'background: {{VALUE}};'
                ],
                'condition' => [
                    'business_hours_striped' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function set_time_zone() {
        $settingsTimeZone = $this->get_settings_for_display();

        if ($settingsTimeZone['dynamic_timezone'] != 'default') { // timezone default checking
            if ($settingsTimeZone['dynamic_timezone'] == 'custom') {
                $ct_input = $settingsTimeZone['custom_timezone_input'] ? $settingsTimeZone['custom_timezone_input'] : '+6';
            } else {
                $ct_input = $settingsTimeZone['dynamic_timezone'];
            }

            return $this->set_gmt_zone($ct_input);
        } else {
            return $this->set_gmt_zone(get_option('gmt_offset'));
        }
    }

    public function set_gmt_zone($receive) {
        // Convert hours to seconds
        $offset_seconds = (float) $receive * 3600;

        // Get GMT time adjusted by offset
        $time = gmdate("g:i:s A", time() + $offset_seconds);

        return $time;
    }

    public function get_display_timezone() {
        $settingsTimeZone = $this->get_settings_for_display();

        if ($settingsTimeZone['dynamic_timezone'] != 'default') {
            if ($settingsTimeZone['dynamic_timezone'] == 'custom') {
                $offset = $settingsTimeZone['custom_timezone_input'] ? $settingsTimeZone['custom_timezone_input'] : '+6';
            } else {
                $offset = $settingsTimeZone['dynamic_timezone'];
            }
        } else {
            // Site timezone - same as current_time().
            return wp_timezone();
        }

        $offset = (float) $offset;
        $hours = (int) floor(abs($offset));
        $minutes = (int) round((abs($offset) - $hours) * 60);

        return new \DateTimeZone(sprintf('%s%02d:%02d', $offset < 0 ? '-' : '+', $hours, $minutes));
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $time_format = get_option('time_format');
        $timeNotation = (strpos($time_format, 'G') !== false || strpos($time_format, 'H') !== false) ? '24h' : '12h';
        $display_tz = $this->get_display_timezone();
        $schedule = $this->get_schedule($settings);
        $now = new \DateTime('now', $display_tz);
        $is_open = $this->is_open_at($schedule, (int) $now->format('w'), (int) $now->format('G') * 60 + (int) $now->format('i'));

        if ($settings['dynamic_timezone'] == 'custom') {
            $ct_input = (isset($settings['custom_timezone_input']) && !empty($settings['custom_timezone_input'])) ? $settings['custom_timezone_input'] : '+6';
        } else {
            $ct_input = $settings['dynamic_timezone'];
        }

        $this->add_render_attribute([
            'business-hours-data' => [
                'data-settings' => [
                    wp_json_encode(
                        array_filter([
                            "id" => esc_attr('business-hours-' . $this->get_id()),
                            'business_hour_style' => $settings['business_hour_style'] == 'default' ? 'static' : 'dynamic',
                            "dynamic_timezone_default" => get_option('gmt_offset'),
                            "dynamic_timezone" => $settings['dynamic_timezone'] == 'default' ? get_option('gmt_offset') : $ct_input,
                            "timeNotation" => $timeNotation,
                            // Status and today's row are recomputed in the browser, so a
                            // cached page doesn't keep showing the hour it was cached in.
                            'schedule' => $schedule,
                            'tz' => $display_tz->getName(),
                            'offset' => $display_tz->getOffset($now) / 60,
                        ], function ($value) {
                            // Keep a 0 (UTC) offset; only drop empty values.
                            return $value !== null && $value !== '';
                        })
                    ),
                ]
            ],
        ]);
        ?>

        <div class="eead-business-hour" <?php $this->print_render_attribute_string('business-hours-data'); ?>>

            <?php
            if ($settings['header_content_type'] != 'none') {
                ?>
                <div class="eead-bh-header">
                    <?php
                    if ($settings['header_content_type'] == 'date') {
                        ?>
                        <div class="eead-bh-current-time">
                            <?php
                            echo esc_html(wp_date($time_format, time(), $display_tz));
                            ?>
                        </div>

                        <div class="eead-bh-current-date">
                            <?php
                            echo esc_html(wp_date(get_option('date_format'), time(), $display_tz));
                            ?>
                        </div>
                        <?php
                    } elseif ($settings['header_content_type'] == 'status') {
                        ?>
                        <div class="eead-bh-open-status<?php echo $is_open ? ' eead-bh-is-open' : ' eead-bh-is-closed'; ?>">
                            <span class="eead-bh-status-open"<?php echo $is_open ? '' : ' hidden'; ?>><?php echo wp_kses_post($settings['header_open_msg']); ?></span>
                            <span class="eead-bh-status-closed"<?php echo $is_open ? ' hidden' : ''; ?>><?php echo wp_kses_post($settings['header_closed_msg']); ?></span>
                        </div>
                        <?php
                    } elseif ($settings['header_content_type'] == 'text') {
                        ?>
                        <div class="eead-bh-custom-text">
                            <?php echo do_shortcode(wp_kses_post($settings['header_text'])); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized before shortcode processing. ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>

            <div class="eead-business-hour-details">
                <?php
                $week = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                $week = $this->set_start_of_week($week);
                $active_day = strtolower($now->format('D')); // sun (not localized)
                $day_index = array_flip(['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']);
                foreach ($week as $day) {
                    ?>
                    <div class="eead-business-hour-row<?php echo ($day == $active_day) ? ' active-day' : ''; ?>" data-day="<?php echo esc_attr($day_index[$day]); ?>">
                        <div class=" eead-business-day">
                            <?php echo wp_kses_post($settings["{$day}day_label"]); ?>
                        </div>
                        <div class="eead-business-time">
                            <?php
                            if ($settings["{$day}_closed"] === 'yes' || empty($settings["{$day}_business_hours"])) {
                                ?>
                                <div class="eead-closed-all-day">
                                    <?php echo wp_kses_post($settings["{$day}_closed_day_msg"]); ?>
                                </div>
                                <?php
                            } else {
                                foreach ($settings["{$day}_business_hours"] as $hours) {
                                    ?>
                                    <div class="eead-business-time-interval">
                                        <?php echo esc_html($hours['start_time']); ?> - <?php echo esc_html($hours['end_time']); ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php if ($settings['footer_content_type'] != 'none') { ?>
                <div class="eead-bh-footer">
                    <?php
                    if ($settings['footer_content_type'] == 'date') {
                        ?>
                        <div class="eead-bh-current-time">
                            <?php
                            echo esc_html(wp_date($time_format, time(), $display_tz));
                            ?>
                        </div>

                        <div class="eead-bh-current-date">
                            <?php
                            echo esc_html(wp_date(get_option('date_format'), time(), $display_tz));
                            ?>
                        </div>
                        <?php
                    } elseif ($settings['footer_content_type'] == 'status') {
                        ?>
                        <div class="eead-bh-open-status<?php echo $is_open ? ' eead-bh-is-open' : ' eead-bh-is-closed'; ?>">
                            <span class="eead-bh-status-open"<?php echo $is_open ? '' : ' hidden'; ?>><?php echo wp_kses_post($settings['footer_open_msg']); ?></span>
                            <span class="eead-bh-status-closed"<?php echo $is_open ? ' hidden' : ''; ?>><?php echo wp_kses_post($settings['footer_closed_msg']); ?></span>
                        </div>
                        <?php
                    } elseif ($settings['footer_content_type'] == 'text') {
                        ?>
                        <div class="eead-bh-custom-text">
                            <?php echo do_shortcode(wp_kses_post($settings['footer_text'])); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized before shortcode processing. ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>

        </div>
        <?php
    }

    /**
     * Opening slots per weekday (0 = Sunday) as [start, end] minutes after midnight.
     */
    private function get_schedule($settings) {
        $schedule = [];
        foreach (['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'] as $i => $day) {
            $schedule[$i] = [];
            if (isset($settings["{$day}_closed"]) && $settings["{$day}_closed"] === 'yes') {
                continue;
            }
            foreach ((array) (isset($settings["{$day}_business_hours"]) ? $settings["{$day}_business_hours"] : []) as $hours) {
                $start = $this->get_minutes(isset($hours['start_time']) ? $hours['start_time'] : '');
                $end = $this->get_minutes(isset($hours['end_time']) ? $hours['end_time'] : '');
                if ($start !== false && $end !== false) {
                    $schedule[$i][] = [$start, $end];
                }
            }
        }
        return $schedule;
    }

    /**
     * An end at or before the start runs past midnight, so the previous day's
     * late slot can still be open in the small hours. Mirrored in frontend.js.
     */
    private function is_open_at($schedule, $dow, $minute) {
        foreach ($schedule[$dow] as $slot) {
            if ($minute >= $slot[0] && ($slot[1] > $slot[0] ? $minute < $slot[1] : true)) {
                return true;
            }
        }
        foreach ($schedule[($dow + 6) % 7] as $slot) {
            if ($slot[1] <= $slot[0] && $minute < $slot[1]) {
                return true;
            }
        }
        return false;
    }

    private function get_minutes($time) {
        if (!is_string($time) || trim($time) === '') {
            return false;
        }

        $formats = array_unique([get_option('time_format'), 'H:i', 'G:i', 'g:i a', 'g:i A', 'h:i a', 'h:i A']);

        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat('!' . $format, trim($time));
            if ($parsed) {
                return (int) $parsed->format('G') * 60 + (int) $parsed->format('i');
            }
        }

        return false;
    }

    private function format_time($time) {

        $wp_time_format = get_option('time_format');

        $time_obj = \DateTime::createFromFormat('H:i', $time);

        if (!$time_obj) {
            return $time;
        }

        return $time_obj->format($wp_time_format);
    }

    private function time_format_to_js($time_format) {
        $js_format = $time_format;

        // AM/PM
        $js_format = str_replace('a', 'K', $js_format);
        $js_format = str_replace('A', 'K', $js_format);
        $js_format = str_replace('g', 'G', $js_format);

        return $js_format;
    }

    private function set_start_of_week($week) {

        /** WordPress Start day of the week. */
        $start_of_week = get_option('start_of_week');

        /** Add offset to array. */
        for ($i = 0; $i < $start_of_week; $i++) {
            $this->array_shift($week);
        }

        return $week;
    }

    private function array_shift(&$arr) {
        $keys = array_keys($arr);
        $val = $arr[$keys[0]];
        unset($arr[$keys[0]]);
        $arr[$keys[0]] = $val;
    }

}
