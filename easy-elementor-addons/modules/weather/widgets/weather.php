<?php

namespace EasyElementorAddons\Modules\Weather\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use DateTime;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Weather extends Widget_Base {

    /* Widget Name */

    public function get_name() {
        return 'eead-weather';
    }

    /* Widget Title */

    public function get_title() {
        return esc_html__('Weather', 'easy-elementor-addons');
    }

    public function get_style_depends() {
        return ['weather-icons'];
    }

    /* Icon */

    public function get_icon() {
        return 'eead-element-icon eead-icons-weather';
    }

    /* Category */

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    /* Controls */

    protected function register_controls() {

        $this->start_controls_section(
            'layout_section', [
                'label' => esc_html__('Layout Section', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'api-notice', [
                'type' => Controls_Manager::NOTICE,
                'heading' => esc_html__('Notice', 'easy-elementor-addons'),
                'content' => esc_html__('API key is required. To add API key ', 'easy-elementor-addons') . '<a target="_blank" href="' . admin_url('admin.php?page=eead-settings') . '">' . esc_html__('Click Here', 'easy-elementor-addons') . '.</a>'
            ]
        );

        /* Country */
        $this->add_control(
            'country_location', [
                'label' => esc_html__('Country', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->get_country_options(),
                'default' => 'AU',
                'label_block' => true
            ]
        );

        /* City */
        $this->add_control(
            'city_location', [
                'label' => esc_html__('City', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Sydney', 'easy-elementor-addons'),
                'placeholder' => esc_html__('City', 'easy-elementor-addons'),
                'separator' => 'after'
            ]
        );

        /* Units */
        $this->add_control(
            'temperature_units', [
                'label' => esc_html__('Temperature Unit', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'standard' => esc_html__('Kelvin', 'easy-elementor-addons'),
                    'metric' => esc_html__('Celsius', 'easy-elementor-addons'),
                    'imperial' => esc_html__('Fahrenheit', 'easy-elementor-addons'),
                ],
                'default' => 'metric'
            ]
        );

        $this->add_control(
            'cache_expiration', [
                'label' => esc_html__('Cache Expiration(sec)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Please set the expiration time in seconds.', 'easy-elementor-addons'),
                'step' => 1,
                'default' => 3600
            ]
        );

        /* Round */
        $this->add_control(
            'round_temp', [
                'label' => esc_html__('Round Temprature Value', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'hide_weather_description', [
                'label' => esc_html__('Hide Weather Condition', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'hide_weather_params', [
                'label' => esc_html__('Hide Weather Variables/Parameters', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );

        $this->add_control(
            'hide_last_updated_time', [
                'label' => esc_html__('Hide Last Updated Time', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons')
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'container_style', [
                'label' => esc_html__('Container', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'container_background',
                'selector' => '{{WRAPPER}} .eead-weather-container',
            ]
        );

        $this->add_control(
            'container_background_overlay', [
                'label' => esc_html__('Background Overlay', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-container:before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'container_background_image[id]!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'container_border',
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
                'selector' => '{{WRAPPER}} .eead-weather-container',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header_style', [
                'label' => esc_html__('Header', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'header_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-weather-header'
            ]
        );

        $this->add_control(
            'header_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'location_style', [
                'label' => esc_html__('Location', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'location_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-location' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'location_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-location'
            ]
        );

        $this->add_responsive_control(
            'location_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-location' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'weather_icon_style', [
                'label' => esc_html__('Weather Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'weather_icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-icon i' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'weather_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'weather_icon_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'temperature_style', [
                'label' => esc_html__('Temperature', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'temperature_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-temperature' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'temperature_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-temperature'
            ]
        );

        $this->add_responsive_control(
            'temperature_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-temperature' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'description_style', [
                'label' => esc_html__('Weather Condition', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hide_weather_description!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-description' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-description'
            ]
        );

        $this->add_responsive_control(
            'description_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'feels_like_style', [
                'label' => esc_html__('Feels Like', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hide_weather_description!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'feels_like_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-like' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'feels_like_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-like'
            ]
        );

        $this->add_responsive_control(
            'feels_like_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-like' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'date_style', [
                'label' => esc_html__('Date', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'date_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-time' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'date_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-time'
            ]
        );

        $this->add_responsive_control(
            'date_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'weather_param_style', [
                'label' => esc_html__('Weather Parameters', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hide_weather_params!' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'weather_param_bg_color',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-weather-container.eead-style2 .eead-weather-parameters > div',
                'condition' => [
                    'layout' => 'style2'
                ]
            ]
        );

        $this->add_responsive_control(
            'weather_param_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-container.eead-style2 .eead-weather-parameters > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout' => 'style2'
                ]
            ]
        );

        $this->add_responsive_control(
            'weather_param_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-container.eead-style2 .eead-weather-parameters > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout' => 'style2'
                ]
            ]
        );

        $this->add_responsive_control(
            'weather_param_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-parameters' => 'gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->start_controls_tabs(
            'param_tabs'
        );

        $this->start_controls_tab(
            'param_label_tab',
            [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-label' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-label'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'param_value_tab',
            [
                'label' => esc_html__('Value', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'value_color', [
                'label' => esc_html__('Value Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-value' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'value_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-value'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'last_updated_style', [
                'label' => esc_html__('Last Updated', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hide_last_updated_time!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'last_updated_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-last-update' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'last_updated_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-weather-last-update'
            ]
        );

        $this->add_responsive_control(
            'last_updated_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-weather-last-update' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'last_updated_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
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
                    '{{WRAPPER}} .eead-weather-last-update' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $eead_general_settings = get_option('eead_general_settings', true);
        $weatherstackApiKey = isset($eead_general_settings['weather_api_key']) ? $eead_general_settings['weather_api_key'] : NULL;

        if (empty($weatherstackApiKey)) {
            echo esc_html__('Please enter the API Key first!', 'easy-elementor-addons');
            return;
        }

        $data = $this->get_weather_data($weatherstackApiKey);
        if (!$data) {
            return;
        }

        $layout = esc_attr($settings['layout']);
        $temp = $data['current']['temperature'];

        $weather_icon = $data['current']['weather_icons'][0];
        $weather_description = $data['current']['weather_descriptions'][0];
        $localtime = $data['location']['localtime'];
        $observation_time = $data['current']['observation_time'];
        $feelslike = $data['current']['feelslike'];
        $weather_code = $data['current']['weather_code'];
        $is_day = $data['current']['is_day'] == 'yes' ? 'day' : 'night';

        $temp_param = [
            'wind' => [
                'label' => esc_html__('Wind', 'easy-elementor-addons'),
                'value' => $data['current']['wind_speed'] . 'Km/hr ' . $data['current']['wind_dir'],
                'icon' => 'wi-windy'
            ],
            'humidity' => [
                'label' => esc_html__('Humidity', 'easy-elementor-addons'),
                'value' => $data['current']['humidity'] . ' %',
                'icon' => 'wi-humidity'
            ],
            'pressure' => [
                'label' => esc_html__('Pressure', 'easy-elementor-addons'),
                'value' => $data['current']['pressure'] . ' hPa',
                'icon' => 'wi-barometer'
            ],
            'cloudcover' => [
                'label' => esc_html__('Clouds', 'easy-elementor-addons'),
                'value' => $data['current']['cloudcover'] . ' %',
                'icon' => 'wi-cloud'
            ],
            'visibility' => [
                'label' => esc_html__('Visibility', 'easy-elementor-addons'),
                'value' => $data['current']['visibility'] . ' km',
                'icon' => 'wi-day-haze'
            ],
            'precip' => [
                'label' => esc_html__('Precipitation', 'easy-elementor-addons'),
                'value' => $data['current']['precip'] . ' mm',
                'icon' => 'wi-rain-mix'
            ],
            'uv_index' => [
                'label' => esc_html__('UV Index', 'easy-elementor-addons'),
                'value' => $data['current']['uv_index'],
                'icon' => 'wi-day-sunny'
            ]
        ];
        ?>
        <div class="eead-weather-container eead-<?php echo esc_attr($layout); ?>">
            <div class="eead-weather">
                <div class="eead-weather-header">
                    <!--<img src="<?php echo esc_url($weather_icon) ?>" alt="<?php echo esc_attr($weather_description); ?>">-->
                    <div class="eead-weather-info">
                        <div class="eead-weather-location">
                            <i class="icofont-location-pin"></i>
                            <span class="eead-weather-city"><?php echo esc_html($data['location']['name']); ?>,</span>
                            <span class="eead-weather-country"><?php echo esc_html($data['location']['country']); ?></s>
                        </div>

                        <?php
                        if ($settings['layout'] == 'style1') {
                            $this->render_icon($weather_code, $is_day);
                        }

                        if ($settings['layout'] != 'style3') {
                            $this->render_temperature($temp);
                        } ?>

                        <div class="eead-weather-time">
                            <?php echo esc_html($this->get_time($localtime, 'l, d  M')); ?>
                        </div>
                    </div>

                    <?php
                    if ($settings['layout'] == 'style3') {
                        $this->render_icon($weather_code, $is_day);
                    } ?>


                    <div class="eead-weather-detail">
                        <?php
                        if ($settings['layout'] == 'style2') {
                            $this->render_icon($weather_code, $is_day);
                        }

                        if ($settings['layout'] == 'style3') {
                            $this->render_temperature($temp);
                        } ?>

                        <?php if ($settings['hide_weather_description'] != 'yes') { ?>

                            <div class="eead-weather-description">
                                <?php echo esc_html($weather_description); ?>
                            </div>

                            <div class="eead-weather-like">
                                <?php echo esc_html__('Feels Like ', 'easy-elementor-addons') . esc_html($this->get_temp($feelslike)); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <?php if ($settings['hide_weather_params'] != 'yes') { ?>
                    <div class="eead-weather-parameters">
                        <?php
                        $show_params = array('wind', 'humidity', 'pressure', 'cloudcover', 'visibility', 'precip', 'uv_index');
                        foreach ($show_params as $param) {
                            echo '<div class="eead-weather-' . esc_attr($param) . '">';
                            echo '<span class="eead-weather-label"><i class="wi ' . esc_attr($temp_param[$param]['icon']) . '"></i><span>' . esc_html($temp_param[$param]['label']) . '</span></span>';
                            echo '<span class="eead-weather-value">' . esc_html($temp_param[$param]['value']) . '</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if ($settings['hide_last_updated_time'] != 'yes') { ?>
                    <div class="eead-weather-last-update"><?php echo esc_html__('Last Updated: ', 'easy-elementor-addons') . esc_html($observation_time); ?></div>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    protected function render_temperature($temp) {
        echo '<div class="eead-weather-temperature">';
        echo esc_html($this->get_temp($temp));
        echo '</div>';
    }

    protected function render_icon($weather_code, $is_day) {
        $icon_mapping = array(
            395 => 'wi-' . $is_day . '-storm-showers',
            392 => 'wi-' . $is_day . '-storm-showers',
            389 => 'wi-' . $is_day . '-thunderstorm',
            386 => 'wi-' . $is_day . '-storm-showers',
            377 => 'wi-' . $is_day . '-hail',
            374 => 'wi-' . $is_day . '-sleet',
            371 => 'wi-' . $is_day . '-snow',
            368 => 'wi-' . $is_day . '-snow',
            365 => 'wi-' . $is_day . '-sleet',
            362 => 'wi-' . $is_day . '-sleet',
            359 => 'wi-' . $is_day . '-rain',
            356 => 'wi-' . $is_day . '-rain',
            353 => 'wi-' . $is_day . '-sprinkle',
            350 => 'wi-' . $is_day . '-hail',
            338 => 'wi-' . $is_day . '-snow',
            335 => 'wi-' . $is_day . '-snow',
            332 => 'wi-' . $is_day . '-snow',
            329 => 'wi-' . $is_day . '-snow',
            326 => 'wi-' . $is_day . '-snow',
            323 => 'wi-' . $is_day . '-snow',
            320 => 'wi-' . $is_day . '-sleet',
            317 => 'wi-' . $is_day . '-sleet',
            314 => 'wi-' . $is_day . '-sleet',
            311 => 'wi-' . $is_day . '-sleet',
            308 => 'wi-' . $is_day . '-rain',
            305 => 'wi-' . $is_day . '-rain',
            302 => 'wi-' . $is_day . '-showers',
            299 => 'wi-' . $is_day . '-showers',
            296 => 'wi-' . $is_day . '-sprinkle',
            293 => 'wi-' . $is_day . '-sprinkle',
            284 => 'wi-' . $is_day . '-sleet',
            281 => 'wi-' . $is_day . '-sleet',
            266 => 'wi-' . $is_day . '-sprinkle',
            263 => 'wi-' . $is_day . '-sprinkle',
            260 => 'wi-' . $is_day . '-fog',
            248 => 'wi-' . $is_day . '-fog',
            230 => 'wi-' . $is_day . '-snow-wind',
            227 => 'wi-' . $is_day . '-snow',
            200 => 'wi-' . $is_day . '-storm-showers',
            185 => 'wi-' . $is_day . '-sleet',
            182 => 'wi-' . $is_day . '-sleet',
            179 => 'wi-' . $is_day . '-snow',
            176 => 'wi-' . $is_day . '-sprinkle',
            143 => 'wi-' . $is_day . '-sprinkle',
            122 => 'wi-' . $is_day . '-fog',
            119 => 'wi-' . $is_day . '-cloudy',
            116 => 'wi-' . $is_day . '-cloudy',
            113 => 'wi-day-sunny'
        );
        echo '<div class="eead-weather-icon">';
        echo '<i class="wi ' . esc_attr($icon_mapping[$weather_code]) . '"></i>';
        echo '</div>';
    }

    protected function get_time($datetime, $format) {
        $date = date_create_from_format('Y-m-d', $datetime);
        $date = new DateTime($date);
        return date_i18n($format, date_timestamp_get($date));
    }

    protected function get_temp($temp) {
        $units = $this->get_settings_for_display('temperature_units');
        $unit = ($units == 'metric') ? 'm' : (($units == 'standard') ? 's' : 'f');

        if ($unit == 'm') {
            $temp_unit = '&#176;C';
        } else if ($unit == 's') {
            $temp = ($temp + 273.15);
            $temp_unit = '&#176;K';
        } else if ($unit == 'f') {
            $temp = ($temp * 1.8) + 32;
            $temp_unit = '&#176;F';
        }

        $temp = $this->get_settings_for_display('round_temp') == 'yes' ? round($temp) : $temp;
        $temp_val = sprintf('%1$s%2$s', $temp, $temp_unit);
        return $temp_val;
    }

    protected function get_weather_data($weatherstackApiKey) {
        $settings = $this->get_settings_for_display();
        $widgetID = $this->get_id();

        $city = $settings['city_location'];
        $country = $settings['country_location'];
        if (empty($city) or empty($country)) {
            echo esc_html__('Oops! It seems that you have left either the city or the country field empty', 'easy-elementor-addons');
            return;
        }


        if (!empty($city)) {
            $location = $city;
            if (!empty($country)) {
                $location .= ',' . $country;
            }
        }
        $transientKey = sprintf('eead-weather-%s-%s', $city, md5($widgetID));
        $weatherTransientData = get_transient($transientKey);

        if (!isset($weatherTransientData) || empty($weatherTransientData)) {
            /* Weather Stack Api Args */
            $request_args = [
                'access_key' => $weatherstackApiKey,
                'query' => urlencode($location),
                'forecast_days' => 6,
                'hourly' => 1,
                'units' => 'm'
            ];

            $request_url = add_query_arg(
                $request_args, 'http://api.weatherstack.com/current'
            );

            $response = wp_remote_get($request_url, array('timeout' => 30));
            $remote_data = wp_remote_retrieve_body($response);
            $remote_data = json_decode($remote_data, true);

            /* Check if something went wrong while fetching from api */
            if (!$remote_data || is_wp_error($remote_data)) {
                echo esc_html__('Oops! Something went wrong while fetching the data', 'easy-elementor-addons');
                return;
            }

            if (isset($remote_data['error'])) {
                if (isset($remote_data['error']['info'])) {
                    echo esc_html($remote_data['error']['info']);
                } else {
                    echo esc_html__('Weather data of this location not found.', 'easy-elementor-addons');
                }
                return;
            }
            set_transient($transientKey, $remote_data, $settings['cache_expiration']);

            return $remote_data;
        } else {
            return $weatherTransientData;
        }
    }

    protected function get_country_options() {
        return [
            'IR' => esc_html__('Iran, Islamic Republic of', 'easy-elementor-addons'),
            'CY' => esc_html__('Cyprus', 'easy-elementor-addons'),
            'SO' => esc_html__('Somalia', 'easy-elementor-addons'),
            'YE' => esc_html__('Yemen', 'easy-elementor-addons'),
            'LY' => esc_html__('Libya', 'easy-elementor-addons'),
            'IQ' => esc_html__('Iraq', 'easy-elementor-addons'),
            'SA' => esc_html__('Saudi Arabia', 'easy-elementor-addons'),
            'AO' => esc_html__('Angola', 'easy-elementor-addons'),
            'AZ' => esc_html__('Azerbaijan', 'easy-elementor-addons'),
            'TZ' => esc_html__('Tanzania, United Republic of', 'easy-elementor-addons'),
            'TM' => esc_html__('Turkmenistan', 'easy-elementor-addons'),
            'SY' => esc_html__('Syrian Arab Republic', 'easy-elementor-addons'),
            'AM' => esc_html__('Armenia', 'easy-elementor-addons'),
            'ZM' => esc_html__('Zambia', 'easy-elementor-addons'),
            'KE' => esc_html__('Kenya', 'easy-elementor-addons'),
            'RW' => esc_html__('Rwanda', 'easy-elementor-addons'),
            'CD' => esc_html__('Congo, the Democratic Republic of the', 'easy-elementor-addons'),
            'DJ' => esc_html__('Djibouti', 'easy-elementor-addons'),
            'UG' => esc_html__('Uganda', 'easy-elementor-addons'),
            'MW' => esc_html__('Malawi', 'easy-elementor-addons'),
            'CF' => esc_html__('Central African Republic', 'easy-elementor-addons'),
            'SC' => esc_html__('Seychelles', 'easy-elementor-addons'),
            'TD' => esc_html__('Chad', 'easy-elementor-addons'),
            'JO' => esc_html__('Jordan', 'easy-elementor-addons'),
            'GR' => esc_html__('Greece', 'easy-elementor-addons'),
            'LB' => esc_html__('Lebanon', 'easy-elementor-addons'),
            'PS' => esc_html__('Palestine, State of', 'easy-elementor-addons'),
            'IL' => esc_html__('Israel', 'easy-elementor-addons'),
            'KW' => esc_html__('Kuwait', 'easy-elementor-addons'),
            'OM' => esc_html__('Oman', 'easy-elementor-addons'),
            'QA' => esc_html__('Qatar', 'easy-elementor-addons'),
            'BH' => esc_html__('Bahrain', 'easy-elementor-addons'),
            'AE' => esc_html__('United Arab Emirates', 'easy-elementor-addons'),
            'TR' => esc_html__('Turkey', 'easy-elementor-addons'),
            'ET' => esc_html__('Ethiopia', 'easy-elementor-addons'),
            'ER' => esc_html__('Eritrea', 'easy-elementor-addons'),
            'EG' => esc_html__('Egypt', 'easy-elementor-addons'),
            'AL' => esc_html__('Albania', 'easy-elementor-addons'),
            'SD' => esc_html__('Sudan', 'easy-elementor-addons'),
            'SS' => esc_html__('South Sudan', 'easy-elementor-addons'),
            'BI' => esc_html__('Burundi', 'easy-elementor-addons'),
            'RU' => esc_html__('Russian Federation', 'easy-elementor-addons'),
            'LV' => esc_html__('Latvia', 'easy-elementor-addons'),
            'EE' => esc_html__('Estonia', 'easy-elementor-addons'),
            'LT' => esc_html__('Lithuania', 'easy-elementor-addons'),
            'UZ' => esc_html__('Uzbekistan', 'easy-elementor-addons'),
            'SE' => esc_html__('Sweden', 'easy-elementor-addons'),
            'KZ' => esc_html__('Kazakhstan', 'easy-elementor-addons'),
            'GE' => esc_html__('Georgia', 'easy-elementor-addons'),
            'UA' => esc_html__('Ukraine', 'easy-elementor-addons'),
            'MD' => esc_html__('Moldova, Republic of', 'easy-elementor-addons'),
            'BY' => esc_html__('Belarus', 'easy-elementor-addons'),
            'FI' => esc_html__('Finland', 'easy-elementor-addons'),
            'RO' => esc_html__('Romania', 'easy-elementor-addons'),
            'HU' => esc_html__('Hungary', 'easy-elementor-addons'),
            'SK' => esc_html__('Slovakia', 'easy-elementor-addons'),
            'BG' => esc_html__('Bulgaria', 'easy-elementor-addons'),
            'PL' => esc_html__('Poland', 'easy-elementor-addons'),
            'RS' => esc_html__('Serbia', 'easy-elementor-addons'),
            'MK' => esc_html__('Macedonia, the Former Yugoslav Republic of', 'easy-elementor-addons'),
            'XK' => esc_html__('Kosovo', 'easy-elementor-addons'),
            'NA' => esc_html__('Namibia', 'easy-elementor-addons'),
            'ZW' => esc_html__('Zimbabwe', 'easy-elementor-addons'),
            'KM' => esc_html__('Comoros', 'easy-elementor-addons'),
            'YT' => esc_html__('Mayotte', 'easy-elementor-addons'),
            'LS' => esc_html__('Lesotho', 'easy-elementor-addons'),
            'BW' => esc_html__('Botswana', 'easy-elementor-addons'),
            'MU' => esc_html__('Mauritius', 'easy-elementor-addons'),
            'SZ' => esc_html__('Swaziland', 'easy-elementor-addons'),
            'RE' => esc_html__('Réunion', 'easy-elementor-addons'),
            'ZA' => esc_html__('South Africa', 'easy-elementor-addons'),
            'MZ' => esc_html__('Mozambique', 'easy-elementor-addons'),
            'MG' => esc_html__('Madagascar', 'easy-elementor-addons'),
            'PK' => esc_html__('Pakistan', 'easy-elementor-addons'),
            'TH' => esc_html__('Thailand', 'easy-elementor-addons'),
            'AF' => esc_html__('Afghanistan', 'easy-elementor-addons'),
            'IN' => esc_html__('India', 'easy-elementor-addons'),
            'BD' => esc_html__('Bangladesh', 'easy-elementor-addons'),
            'ID' => esc_html__('Indonesia', 'easy-elementor-addons'),
            'TJ' => esc_html__('Tajikistan', 'easy-elementor-addons'),
            'MY' => esc_html__('Malaysia', 'easy-elementor-addons'),
            'KG' => esc_html__('Kyrgyzstan', 'easy-elementor-addons'),
            'LK' => esc_html__('Sri Lanka', 'easy-elementor-addons'),
            'BT' => esc_html__('Bhutan', 'easy-elementor-addons'),
            'CN' => esc_html__('China', 'easy-elementor-addons'),
            'MV' => esc_html__('Maldives', 'easy-elementor-addons'),
            'NP' => esc_html__('Nepal', 'easy-elementor-addons'),
            'MM' => esc_html__('Myanmar', 'easy-elementor-addons'),
            'MN' => esc_html__('Mongolia', 'easy-elementor-addons'),
            'TF' => esc_html__('French Southern Territories', 'easy-elementor-addons'),
            'VN' => esc_html__('Viet Nam', 'easy-elementor-addons'),
            'TL' => esc_html__('Timor-Leste', 'easy-elementor-addons'),
            'LA' => esc_html__('Lao People\'s Democratic Republic', 'easy-elementor-addons'),
            'TW' => esc_html__('Taiwan, Province of China', 'easy-elementor-addons'),
            'PH' => esc_html__('Philippines', 'easy-elementor-addons'),
            'HK' => esc_html__('Hong Kong', 'easy-elementor-addons'),
            'BN' => esc_html__('Brunei Darussalam', 'easy-elementor-addons'),
            'MO' => esc_html__('Macao', 'easy-elementor-addons'),
            'KH' => esc_html__('Cambodia', 'easy-elementor-addons'),
            'KR' => esc_html__('Korea, Republic of', 'easy-elementor-addons'),
            'JP' => esc_html__('Japan', 'easy-elementor-addons'),
            'KP' => esc_html__('Korea, Democratic People\'s Republic of', 'easy-elementor-addons'),
            'SG' => esc_html__('Singapore', 'easy-elementor-addons'),
            'AU' => esc_html__('Australia', 'easy-elementor-addons'),
            'CX' => esc_html__('Christmas Island', 'easy-elementor-addons'),
            'FM' => esc_html__('Micronesia, Federated States of', 'easy-elementor-addons'),
            'PG' => esc_html__('Papua New Guinea', 'easy-elementor-addons'),
            'SB' => esc_html__('Solomon Islands', 'easy-elementor-addons'),
            'KI' => esc_html__('Kiribati', 'easy-elementor-addons'),
            'TV' => esc_html__('Tuvalu', 'easy-elementor-addons'),
            'MH' => esc_html__('Marshall Islands', 'easy-elementor-addons'),
            'VU' => esc_html__('Vanuatu', 'easy-elementor-addons'),
            'NC' => esc_html__('New Caledonia', 'easy-elementor-addons'),
            'NF' => esc_html__('Norfolk Island', 'easy-elementor-addons'),
            'NZ' => esc_html__('New Zealand', 'easy-elementor-addons'),
            'FJ' => esc_html__('Fiji', 'easy-elementor-addons'),
            'CM' => esc_html__('Cameroon', 'easy-elementor-addons'),
            'SN' => esc_html__('Senegal', 'easy-elementor-addons'),
            'CG' => esc_html__('Congo', 'easy-elementor-addons'),
            'PT' => esc_html__('Portugal', 'easy-elementor-addons'),
            'LR' => esc_html__('Liberia', 'easy-elementor-addons'),
            'CI' => esc_html__('Côte d\'Ivoire', 'easy-elementor-addons'),
            'GH' => esc_html__('Ghana', 'easy-elementor-addons'),
            'GQ' => esc_html__('Equatorial Guinea', 'easy-elementor-addons'),
            'NG' => esc_html__('Nigeria', 'easy-elementor-addons'),
            'BF' => esc_html__('Burkina Faso', 'easy-elementor-addons'),
            'TG' => esc_html__('Togo', 'easy-elementor-addons'),
            'GW' => esc_html__('Guinea-Bissau', 'easy-elementor-addons'),
            'MR' => esc_html__('Mauritania', 'easy-elementor-addons'),
            'BJ' => esc_html__('Benin', 'easy-elementor-addons'),
            'GA' => esc_html__('Gabon', 'easy-elementor-addons'),
            'SL' => esc_html__('Sierra Leone', 'easy-elementor-addons'),
            'ST' => esc_html__('Sao Tome and Principe', 'easy-elementor-addons'),
            'GI' => esc_html__('Gibraltar', 'easy-elementor-addons'),
            'GM' => esc_html__('Gambia', 'easy-elementor-addons'),
            'GN' => esc_html__('Guinea', 'easy-elementor-addons'),
            'NE' => esc_html__('Niger', 'easy-elementor-addons'),
            'ML' => esc_html__('Mali', 'easy-elementor-addons'),
            'EH' => esc_html__('Western Sahara', 'easy-elementor-addons'),
            'TN' => esc_html__('Tunisia', 'easy-elementor-addons'),
            'DZ' => esc_html__('Algeria', 'easy-elementor-addons'),
            'ES' => esc_html__('Spain', 'easy-elementor-addons'),
            'IT' => esc_html__('Italy', 'easy-elementor-addons'),
            'MA' => esc_html__('Morocco', 'easy-elementor-addons'),
            'MT' => esc_html__('Malta', 'easy-elementor-addons'),
            'DK' => esc_html__('Denmark', 'easy-elementor-addons'),
            'FO' => esc_html__('Faroe Islands', 'easy-elementor-addons'),
            'IS' => esc_html__('Iceland', 'easy-elementor-addons'),
            'GB' => esc_html__('United Kingdom', 'easy-elementor-addons'),
            'CH' => esc_html__('Switzerland', 'easy-elementor-addons'),
            'SJ' => esc_html__('Svalbard and Jan Mayen', 'easy-elementor-addons'),
            'NL' => esc_html__('Netherlands', 'easy-elementor-addons'),
            'AT' => esc_html__('Austria', 'easy-elementor-addons'),
            'BE' => esc_html__('Belgium', 'easy-elementor-addons'),
            'DE' => esc_html__('Germany', 'easy-elementor-addons'),
            'LU' => esc_html__('Luxembourg', 'easy-elementor-addons'),
            'IE' => esc_html__('Ireland', 'easy-elementor-addons'),
            'FR' => esc_html__('France', 'easy-elementor-addons'),
            'MC' => esc_html__('Monaco', 'easy-elementor-addons'),
            'AD' => esc_html__('Andorra', 'easy-elementor-addons'),
            'AX' => esc_html__('Åland Islands', 'easy-elementor-addons'),
            'LI' => esc_html__('Liechtenstein', 'easy-elementor-addons'),
            'JE' => esc_html__('Jersey', 'easy-elementor-addons'),
            'IM' => esc_html__('Isle of Man', 'easy-elementor-addons'),
            'GG' => esc_html__('Guernsey', 'easy-elementor-addons'),
            'CZ' => esc_html__('Czech Republic', 'easy-elementor-addons'),
            'NO' => esc_html__('Norway', 'easy-elementor-addons'),
            'SM' => esc_html__('San Marino', 'easy-elementor-addons'),
            'BA' => esc_html__('Bosnia and Herzegovina', 'easy-elementor-addons'),
            'HR' => esc_html__('Croatia', 'easy-elementor-addons'),
            'SI' => esc_html__('Slovenia', 'easy-elementor-addons'),
            'ME' => esc_html__('Montenegro', 'easy-elementor-addons'),
            'SH' => esc_html__('Saint Helena, Ascension and Tristan da Cunha', 'easy-elementor-addons'),
            'BB' => esc_html__('Barbados', 'easy-elementor-addons'),
            'CV' => esc_html__('Cape Verde', 'easy-elementor-addons'),
            'GY' => esc_html__('Guyana', 'easy-elementor-addons'),
            'GF' => esc_html__('French Guiana', 'easy-elementor-addons'),
            'SR' => esc_html__('Suriname', 'easy-elementor-addons'),
            'BR' => esc_html__('Brazil', 'easy-elementor-addons'),
            'GL' => esc_html__('Greenland', 'easy-elementor-addons'),
            'PM' => esc_html__('Saint Pierre and Miquelon', 'easy-elementor-addons'),
            'GS' => esc_html__('South Georgia and the South Sandwich Islands', 'easy-elementor-addons'),
            'FK' => esc_html__('Falkland Islands (Malvinas)', 'easy-elementor-addons'),
            'AR' => esc_html__('Argentina', 'easy-elementor-addons'),
            'PY' => esc_html__('Paraguay', 'easy-elementor-addons'),
            'UY' => esc_html__('Uruguay', 'easy-elementor-addons'),
            'VE' => esc_html__('Venezuela, Bolivarian Republic of', 'easy-elementor-addons'),
            'MX' => esc_html__('Mexico', 'easy-elementor-addons'),
            'JM' => esc_html__('Jamaica', 'easy-elementor-addons'),
            'DO' => esc_html__('Dominican Republic', 'easy-elementor-addons'),
            'CW' => esc_html__('Curaçao', 'easy-elementor-addons'),
            'SX' => esc_html__('Sint Maarten (Dutch part)', 'easy-elementor-addons'),
            'CU' => esc_html__('Cuba', 'easy-elementor-addons'),
            'MQ' => esc_html__('Martinique', 'easy-elementor-addons'),
            'BS' => esc_html__('Bahamas', 'easy-elementor-addons'),
            'BM' => esc_html__('Bermuda', 'easy-elementor-addons'),
            'AI' => esc_html__('Anguilla', 'easy-elementor-addons'),
            'TT' => esc_html__('Trinidad and Tobago', 'easy-elementor-addons'),
            'KN' => esc_html__('Saint Kitts and Nevis', 'easy-elementor-addons'),
            'DM' => esc_html__('Dominica', 'easy-elementor-addons'),
            'AG' => esc_html__('Antigua and Barbuda', 'easy-elementor-addons'),
            'LC' => esc_html__('Saint Lucia', 'easy-elementor-addons'),
            'TC' => esc_html__('Turks and Caicos Islands', 'easy-elementor-addons'),
            'AW' => esc_html__('Aruba', 'easy-elementor-addons'),
            'VG' => esc_html__('Virgin Islands, British', 'easy-elementor-addons'),
            'VC' => esc_html__('Saint Vincent and the Grenadines', 'easy-elementor-addons'),
            'MS' => esc_html__('Montserrat', 'easy-elementor-addons'),
            'GP' => esc_html__('Guadeloupe', 'easy-elementor-addons'),
            'MF' => esc_html__('Saint Martin (French part)', 'easy-elementor-addons'),
            'BL' => esc_html__('Saint Barthélemy', 'easy-elementor-addons'),
            'GD' => esc_html__('Grenada', 'easy-elementor-addons'),
            'KY' => esc_html__('Cayman Islands', 'easy-elementor-addons'),
            'BZ' => esc_html__('Belize', 'easy-elementor-addons'),
            'SV' => esc_html__('El Salvador', 'easy-elementor-addons'),
            'GT' => esc_html__('Guatemala', 'easy-elementor-addons'),
            'HN' => esc_html__('Honduras', 'easy-elementor-addons'),
            'NI' => esc_html__('Nicaragua', 'easy-elementor-addons'),
            'CR' => esc_html__('Costa Rica', 'easy-elementor-addons'),
            'EC' => esc_html__('Ecuador', 'easy-elementor-addons'),
            'CO' => esc_html__('Colombia', 'easy-elementor-addons'),
            'PE' => esc_html__('Peru', 'easy-elementor-addons'),
            'PA' => esc_html__('Panama', 'easy-elementor-addons'),
            'HT' => esc_html__('Haiti', 'easy-elementor-addons'),
            'CL' => esc_html__('Chile', 'easy-elementor-addons'),
            'BO' => esc_html__('Bolivia, Plurinational State of', 'easy-elementor-addons'),
            'PN' => esc_html__('Pitcairn', 'easy-elementor-addons'),
            'TO' => esc_html__('Tonga', 'easy-elementor-addons'),
            'PF' => esc_html__('French Polynesia', 'easy-elementor-addons'),
            'WF' => esc_html__('Wallis and Futuna', 'easy-elementor-addons'),
            'WS' => esc_html__('Samoa', 'easy-elementor-addons'),
            'CK' => esc_html__('Cook Islands', 'easy-elementor-addons'),
            'NU' => esc_html__('Niue', 'easy-elementor-addons'),
            'GU' => esc_html__('Guam', 'easy-elementor-addons'),
            'US' => esc_html__('United States', 'easy-elementor-addons'),
            'PR' => esc_html__('Puerto Rico', 'easy-elementor-addons'),
            'VI' => esc_html__('Virgin Islands, U.S.', 'easy-elementor-addons'),
            'AS' => esc_html__('American Samoa', 'easy-elementor-addons'),
            'CA' => esc_html__('Canada', 'easy-elementor-addons'),
            'VA' => esc_html__('Holy See (Vatican City State)', 'easy-elementor-addons'),
            'PW' => esc_html__('Palau', 'easy-elementor-addons'),
            'CC' => esc_html__('Cocos (Keeling) Islands', 'easy-elementor-addons'),
            'NR' => esc_html__('Nauru', 'easy-elementor-addons'),
            'MP' => esc_html__('Northern Mariana Islands', 'easy-elementor-addons'),
            'BQ' => esc_html__('Bonaire, Sint Eustatius and Saba', 'easy-elementor-addons'),
            'AQ' => esc_html__('Antarctica', 'easy-elementor-addons'),
            'BV' => esc_html__('Bouvet Island', 'easy-elementor-addons'),
            'IO' => esc_html__('British Indian Ocean Territory', 'easy-elementor-addons'),
            'HM' => esc_html__('Heard Island and McDonald Islands', 'easy-elementor-addons'),
            'TK' => esc_html__('Tokelau', 'easy-elementor-addons'),
            'UM' => esc_html__('United States Minor Outlying Islands', 'easy-elementor-addons'),
        ];
    }

    protected function get_language_options() {

        return [
            'ab' => esc_html__('Abkhaz', 'easy-elementor-addons'),
            'aa' => esc_html__('Afar', 'easy-elementor-addons'),
            'af' => esc_html__('Afrikaans', 'easy-elementor-addons'),
            'ak' => esc_html__('Akan', 'easy-elementor-addons'),
            'sq' => esc_html__('Albanian', 'easy-elementor-addons'),
            'am' => esc_html__('Amharic', 'easy-elementor-addons'),
            'ar' => esc_html__('Arabic', 'easy-elementor-addons'),
            'an' => esc_html__('Aragonese', 'easy-elementor-addons'),
            'hy' => esc_html__('Armenian', 'easy-elementor-addons'),
            'as' => esc_html__('Assamese', 'easy-elementor-addons'),
            'av' => esc_html__('Avaric', 'easy-elementor-addons'),
            'ae' => esc_html__('Avestan', 'easy-elementor-addons'),
            'ay' => esc_html__('Aymara', 'easy-elementor-addons'),
            'az' => esc_html__('Azerbaijani', 'easy-elementor-addons'),
            'bm' => esc_html__('Bambara', 'easy-elementor-addons'),
            'ba' => esc_html__('Bashkir', 'easy-elementor-addons'),
            'eu' => esc_html__('Basque', 'easy-elementor-addons'),
            'be' => esc_html__('Belarusian', 'easy-elementor-addons'),
            'bn' => esc_html__('Bengali; Bangla', 'easy-elementor-addons'),
            'bh' => esc_html__('Bihari', 'easy-elementor-addons'),
            'bi' => esc_html__('Bislama', 'easy-elementor-addons'),
            'bs' => esc_html__('Bosnian', 'easy-elementor-addons'),
            'br' => esc_html__('Breton', 'easy-elementor-addons'),
            'bg' => esc_html__('Bulgarian', 'easy-elementor-addons'),
            'my' => esc_html__('Burmese', 'easy-elementor-addons'),
            'ca' => esc_html__('Catalan; Valencian', 'easy-elementor-addons'),
            'ch' => esc_html__('Chamorro', 'easy-elementor-addons'),
            'ce' => esc_html__('Chechen', 'easy-elementor-addons'),
            'ny' => esc_html__('Chichewa; Chewa; Nyanja', 'easy-elementor-addons'),
            'zh' => esc_html__('Chinese', 'easy-elementor-addons'),
            'cv' => esc_html__('Chuvash', 'easy-elementor-addons'),
            'kw' => esc_html__('Cornish', 'easy-elementor-addons'),
            'co' => esc_html__('Corsican', 'easy-elementor-addons'),
            'cr' => esc_html__('Cree', 'easy-elementor-addons'),
            'hr' => esc_html__('Croatian', 'easy-elementor-addons'),
            'cs' => esc_html__('Czech', 'easy-elementor-addons'),
            'da' => esc_html__('Danish', 'easy-elementor-addons'),
            'dv' => esc_html__('Divehi; Dhivehi; Maldivian;', 'easy-elementor-addons'),
            'nl' => esc_html__('Dutch', 'easy-elementor-addons'),
            'dz' => esc_html__('Dzongkha', 'easy-elementor-addons'),
            'en' => esc_html__('English', 'easy-elementor-addons'),
            'eo' => esc_html__('Esperanto', 'easy-elementor-addons'),
            'et' => esc_html__('Estonian', 'easy-elementor-addons'),
            'ee' => esc_html__('Ewe', 'easy-elementor-addons'),
            'fo' => esc_html__('Faroese', 'easy-elementor-addons'),
            'fj' => esc_html__('Fijian', 'easy-elementor-addons'),
            'fi' => esc_html__('Finnish', 'easy-elementor-addons'),
            'fr' => esc_html__('French', 'easy-elementor-addons'),
            'ff' => esc_html__('Fula; Fulah; Pulaar; Pular', 'easy-elementor-addons'),
            'gl' => esc_html__('Galician', 'easy-elementor-addons'),
            'ka' => esc_html__('Georgian', 'easy-elementor-addons'),
            'de' => esc_html__('German', 'easy-elementor-addons'),
            'el' => esc_html__('Greek, Modern', 'easy-elementor-addons'),
            'gn' => esc_html__('GuaranÃ­', 'easy-elementor-addons'),
            'gu' => esc_html__('Gujarati', 'easy-elementor-addons'),
            'ht' => esc_html__('Haitian; Haitian Creole', 'easy-elementor-addons'),
            'ha' => esc_html__('Hausa', 'easy-elementor-addons'),
            'he' => esc_html__('Hebrew (modern)', 'easy-elementor-addons'),
            'hz' => esc_html__('Herero', 'easy-elementor-addons'),
            'hi' => esc_html__('Hindi', 'easy-elementor-addons'),
            'ho' => esc_html__('Hiri Motu', 'easy-elementor-addons'),
            'hu' => esc_html__('Hungarian', 'easy-elementor-addons'),
            'ia' => esc_html__('Interlingua', 'easy-elementor-addons'),
            'id' => esc_html__('Indonesian', 'easy-elementor-addons'),
            'ie' => esc_html__('Interlingue', 'easy-elementor-addons'),
            'ga' => esc_html__('Irish', 'easy-elementor-addons'),
            'ig' => esc_html__('Igbo', 'easy-elementor-addons'),
            'ik' => esc_html__('Inupiaq', 'easy-elementor-addons'),
            'io' => esc_html__('Ido', 'easy-elementor-addons'),
            'is' => esc_html__('Icelandic', 'easy-elementor-addons'),
            'it' => esc_html__('Italian', 'easy-elementor-addons'),
            'iu' => esc_html__('Inuktitut', 'easy-elementor-addons'),
            'ja' => esc_html__('Japanese', 'easy-elementor-addons'),
            'jv' => esc_html__('Javanese', 'easy-elementor-addons'),
            'kl' => esc_html__('Kalaallisut, Greenlandic', 'easy-elementor-addons'),
            'kn' => esc_html__('Kannada', 'easy-elementor-addons'),
            'kr' => esc_html__('Kanuri', 'easy-elementor-addons'),
            'ks' => esc_html__('Kashmiri', 'easy-elementor-addons'),
            'kk' => esc_html__('Kazakh', 'easy-elementor-addons'),
            'km' => esc_html__('Khmer', 'easy-elementor-addons'),
            'ki' => esc_html__('Kikuyu, Gikuyu', 'easy-elementor-addons'),
            'rw' => esc_html__('Kinyarwanda', 'easy-elementor-addons'),
            'ky' => esc_html__('Kyrgyz', 'easy-elementor-addons'),
            'kv' => esc_html__('Komi', 'easy-elementor-addons'),
            'kg' => esc_html__('Kongo', 'easy-elementor-addons'),
            'ko' => esc_html__('Korean', 'easy-elementor-addons'),
            'ku' => esc_html__('Kurdish', 'easy-elementor-addons'),
            'kj' => esc_html__('Kwanyama, Kuanyama', 'easy-elementor-addons'),
            'la' => esc_html__('Latin', 'easy-elementor-addons'),
            'lb' => esc_html__('Luxembourgish, Letzeburgesch', 'easy-elementor-addons'),
            'lg' => esc_html__('Ganda', 'easy-elementor-addons'),
            'li' => esc_html__('Limburgish, Limburgan, Limburger', 'easy-elementor-addons'),
            'ln' => esc_html__('Lingala', 'easy-elementor-addons'),
            'lo' => esc_html__('Lao', 'easy-elementor-addons'),
            'lt' => esc_html__('Lithuanian', 'easy-elementor-addons'),
            'lu' => esc_html__('Luba-Katanga', 'easy-elementor-addons'),
            'lv' => esc_html__('Latvian', 'easy-elementor-addons'),
            'gv' => esc_html__('Manx', 'easy-elementor-addons'),
            'mk' => esc_html__('Macedonian', 'easy-elementor-addons'),
            'mg' => esc_html__('Malagasy', 'easy-elementor-addons'),
            'ms' => esc_html__('Malay', 'easy-elementor-addons'),
            'ml' => esc_html__('Malayalam', 'easy-elementor-addons'),
            'mt' => esc_html__('Maltese', 'easy-elementor-addons'),
            'mi' => esc_html__('MÄori', 'easy-elementor-addons'),
            'mr' => esc_html__('Marathi (MarÄá¹­hÄ«)', 'easy-elementor-addons'),
            'mh' => esc_html__('Marshallese', 'easy-elementor-addons'),
            'mn' => esc_html__('Mongolian', 'easy-elementor-addons'),
            'na' => esc_html__('Nauru', 'easy-elementor-addons'),
            'nv' => esc_html__('Navajo, Navaho', 'easy-elementor-addons'),
            'nb' => esc_html__('Norwegian BokmÃ¥l', 'easy-elementor-addons'),
            'nd' => esc_html__('North Ndebele', 'easy-elementor-addons'),
            'ne' => esc_html__('Nepali', 'easy-elementor-addons'),
            'ng' => esc_html__('Ndonga', 'easy-elementor-addons'),
            'nn' => esc_html__('Norwegian Nynorsk', 'easy-elementor-addons'),
            'no' => esc_html__('Norwegian', 'easy-elementor-addons'),
            'ii' => esc_html__('Nuosu', 'easy-elementor-addons'),
            'nr' => esc_html__('South Ndebele', 'easy-elementor-addons'),
            'oc' => esc_html__('Occitan', 'easy-elementor-addons'),
            'oj' => esc_html__('Ojibwe, Ojibwa', 'easy-elementor-addons'),
            'cu' => esc_html__('Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic', 'easy-elementor-addons'),
            'om' => esc_html__('Oromo', 'easy-elementor-addons'),
            'or' => esc_html__('Oriya', 'easy-elementor-addons'),
            'os' => esc_html__('Ossetian, Ossetic', 'easy-elementor-addons'),
            'pa' => esc_html__('Panjabi, Punjabi', 'easy-elementor-addons'),
            'pi' => esc_html__('PÄli', 'easy-elementor-addons'),
            'fa' => esc_html__('Persian (Farsi)', 'easy-elementor-addons'),
            'pl' => esc_html__('Polish', 'easy-elementor-addons'),
            'ps' => esc_html__('Pashto, Pushto', 'easy-elementor-addons'),
            'pt' => esc_html__('Portuguese', 'easy-elementor-addons'),
            'qu' => esc_html__('Quechua', 'easy-elementor-addons'),
            'rm' => esc_html__('Romansh', 'easy-elementor-addons'),
            'rn' => esc_html__('Kirundi', 'easy-elementor-addons'),
            'ro' => esc_html__('Romanian, [])', 'easy-elementor-addons'),
            'ru' => esc_html__('Russian', 'easy-elementor-addons'),
            'sa' => esc_html__('Sanskrit (Saá¹ská¹›ta)', 'easy-elementor-addons'),
            'sc' => esc_html__('Sardinian', 'easy-elementor-addons'),
            'sd' => esc_html__('Sindhi', 'easy-elementor-addons'),
            'se' => esc_html__('Northern Sami', 'easy-elementor-addons'),
            'sm' => esc_html__('Samoan', 'easy-elementor-addons'),
            'sg' => esc_html__('Sango', 'easy-elementor-addons'),
            'sr' => esc_html__('Serbian', 'easy-elementor-addons'),
            'gd' => esc_html__('Scottish Gaelic; Gaelic', 'easy-elementor-addons'),
            'sn' => esc_html__('Shona', 'easy-elementor-addons'),
            'si' => esc_html__('Sinhala, Sinhalese', 'easy-elementor-addons'),
            'sk' => esc_html__('Slovak', 'easy-elementor-addons'),
            'sl' => esc_html__('Slovene', 'easy-elementor-addons'),
            'so' => esc_html__('Somali', 'easy-elementor-addons'),
            'st' => esc_html__('Southern Sotho', 'easy-elementor-addons'),
            'az' => esc_html__('South Azerbaijani', 'easy-elementor-addons'),
            'es' => esc_html__('Spanish; Castilian', 'easy-elementor-addons'),
            'su' => esc_html__('Sundanese', 'easy-elementor-addons'),
            'sw' => esc_html__('Swahili', 'easy-elementor-addons'),
            'ss' => esc_html__('Swati', 'easy-elementor-addons'),
            'sv' => esc_html__('Swedish', 'easy-elementor-addons'),
            'ta' => esc_html__('Tamil', 'easy-elementor-addons'),
            'te' => esc_html__('Telugu', 'easy-elementor-addons'),
            'tg' => esc_html__('Tajik', 'easy-elementor-addons'),
            'th' => esc_html__('Thai', 'easy-elementor-addons'),
            'ti' => esc_html__('Tigrinya', 'easy-elementor-addons'),
            'bo' => esc_html__('Tibetan Standard, Tibetan, Central', 'easy-elementor-addons'),
            'tk' => esc_html__('Turkmen', 'easy-elementor-addons'),
            'tl' => esc_html__('Tagalog', 'easy-elementor-addons'),
            'tn' => esc_html__('Tswana', 'easy-elementor-addons'),
            'to' => esc_html__('Tonga (Tonga Islands)', 'easy-elementor-addons'),
            'tr' => esc_html__('Turkish', 'easy-elementor-addons'),
            'ts' => esc_html__('Tsonga', 'easy-elementor-addons'),
            'tt' => esc_html__('Tatar', 'easy-elementor-addons'),
            'tw' => esc_html__('Twi', 'easy-elementor-addons'),
            'ty' => esc_html__('Tahitian', 'easy-elementor-addons'),
            'ug' => esc_html__('Uyghur, Uighur', 'easy-elementor-addons'),
            'uk' => esc_html__('Ukrainian', 'easy-elementor-addons'),
            'ur' => esc_html__('Urdu', 'easy-elementor-addons'),
            'uz' => esc_html__('Uzbek', 'easy-elementor-addons'),
            've' => esc_html__('Venda', 'easy-elementor-addons'),
            'vi' => esc_html__('Vietnamese', 'easy-elementor-addons'),
            'vo' => esc_html__('VolapÃ¼k', 'easy-elementor-addons'),
            'wa' => esc_html__('Walloon', 'easy-elementor-addons'),
            'cy' => esc_html__('Welsh', 'easy-elementor-addons'),
            'wo' => esc_html__('Wolof', 'easy-elementor-addons'),
            'fy' => esc_html__('Western Frisian', 'easy-elementor-addons'),
            'xh' => esc_html__('Xhosa', 'easy-elementor-addons'),
            'yi' => esc_html__('Yiddish', 'easy-elementor-addons'),
            'yo' => esc_html__('Yoruba', 'easy-elementor-addons'),
            'za' => esc_html__('Zhuang, Chuang', 'easy-elementor-addons'),
            'zu' => esc_html__('Zulu', 'easy-elementor-addons'),
        ];
    }

}
