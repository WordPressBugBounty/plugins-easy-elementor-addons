<?php

namespace EasyElementorAddons\Modules\AdvancedMap\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Map Widget
 */
class AdvancedMap extends Widget_Base {

    public function get_name() {
        return 'eead-advanced-map';
    }

    public function get_title() {
        return esc_html__('Advanced Map', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-map';
    }

    public function get_keywords() {
        return ['map', 'google map', 'google'];
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['gmap-api'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'marker_controls_section', [
                'label' => esc_html__('Markers', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'api-notice', [
                'type' => Controls_Manager::NOTICE,
                'heading' => esc_html__('Notice', 'easy-elementor-addons'),
                'content' => esc_html__('Google Map API key is required. To add Google Map API key ', 'easy-elementor-addons') . '<a target="_blank" href="' . admin_url('admin.php?page=eead-settings') . '">' . esc_html__('Click Here', 'easy-elementor-addons') . '</a>'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'lat', [
                'label' => esc_html__('Latitude', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '40.712775',
                'placeholder' => esc_html__('Enter latitude here', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'long', [
                'label' => esc_html__('Longitude', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '-74.005973',
                'placeholder' => esc_html__('Enter latitude here', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'lat_lang_notice', [
                'type' => Controls_Manager::NOTICE,
                'heading' => esc_html__('Notice', 'easy-elementor-addons'),
                'content' => esc_html__('Get the Latitude and Longitude value by Location Address from ', 'easy-elementor-addons') . '<a target="_blank" href="https://www.latlong.net/">' . esc_html__('Here.', 'easy-elementor-addons') . '</a>'
            ]
        );

        $repeater->add_control(
            'address', [
                'label' => esc_html__('Address', 'easy-elementor-addons'),
                'description' => esc_html__('Use line break to move to next line.', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'New York City Hall, 260, Broadway,<br/> New York County, New York, 10000, United States',
                'placeholder' => esc_html__('Enter address here..', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Upload Pin Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA
            ]
        );

        $repeater->add_control(
            'icon_size', [
                'label' => esc_html__('Pin Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ]
                ],
                'default' => [
                    'size' => 50,
                    'unit' => 'px',
                ]
            ]
        );

        $repeater->add_control(
            'info_window_onload', [
                'label' => esc_html__('Info Window On Load', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Open', 'easy-elementor-addons'),
                'label_off' => esc_html__('Close', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'markers', [
                'label' => esc_html__('Markers', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'lat' => '34.1063202',
                        'long' => '-118.1418337',
                        'address' => esc_html__('Enter Address Here', 'easy-elementor-addons'),
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general', [
                'label' => esc_html__('General Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 300,
                'selectors' => [
                    '{{WRAPPER}} .eead-gmap-markers' => 'height:{{VALUE}}px',
                ]
            ]
        );

        $this->add_control(
            'zoom', [
                'label' => esc_html__('Zoom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 20,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 13,
                ]
            ]
        );

        $this->add_control(
            'animate', [
                'label' => esc_html__('Animate Marker', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'scrollwheel', [
                'label' => esc_html__('Scrollwheel Zoom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'separator' => 'before',
                'default' => 'enable',
                'options' => array(
                    'enable' => esc_html__('Enabled', 'easy-elementor-addons'),
                    'disable' => esc_html__('Disabled', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'zoom_controls', [
                'label' => esc_html__('Zoom Controls', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__('Show', 'easy-elementor-addons'),
                    'hide' => esc_html__('Hide', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'fullscreen_control', [
                'label' => esc_html__('Fullscreen Control', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__('Show', 'easy-elementor-addons'),
                    'hide' => esc_html__('Hide', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'street_view', [
                'label' => esc_html__('Street View Controls', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__('Show', 'easy-elementor-addons'),
                    'hide' => esc_html__('Hide', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'map_type', [
                'label' => esc_html__('Map Type Controls', 'easy-elementor-addons'),
                'description' => esc_html__('Map/Satellite', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__('Show', 'easy-elementor-addons'),
                    'hide' => esc_html__('Hide', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'drggable', [
                'label' => esc_html__('Is Map Draggable?', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => esc_html__('Yes', 'easy-elementor-addons'),
                    'no' => esc_html__('No', 'easy-elementor-addons'),
                )
            ]
        );

        $this->add_control(
            'snazzy_style', [
                'label' => esc_html__('Snazzy Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'separator' => 'before',
                'description' => sprintf(esc_html__('Choose any map styles by visiting %1$sSnazzy Maps%2$s. Copy any Javascript Style Array and paste here.', 'easy-elementor-addons'), '<a target="_blank" href="https://snazzymaps.com/explore">', '</a>')
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $markers = $settings['markers'];

        if ($settings['drggable'] === 'no') {
            $this->add_render_attribute('wrapper', [
                'data-gestureHandling' => 'none'
            ]);
        }

        $this->add_render_attribute('wrapper', [
            'data-zoom' => $settings['zoom']['size'],
            'data-scrollwheel' => $settings['scrollwheel'] == 'enable' ? true : NULL,
            'data-zoomControl' => $settings['zoom_controls'] == 'show' ? true : NULL,
            'data-fullscreenControl' => $settings['fullscreen_control'] == 'show' ? true : NULL,
            'data-streetViewControl' => $settings['street_view'] == 'show' ? true : NULL,
            'data-mapTypeControl' => $settings['map_type'] == 'show' ? true : NULL,
            'data-style' => $settings['snazzy_style'],
            'data-animate' => 'animate-' . $settings['animate']
        ]);

        if (count($markers) >= 1) {
            ?>
            <div class="eead-gmap-container">
                <div class="eead-gmap-markers" <?php $this->print_render_attribute_string('wrapper'); ?>>
                    <?php
                    foreach ($markers as $marker) {
                        ?>
                        <div class="eead-gmap-marker" data-lat="<?php echo esc_attr($marker['lat']); ?>" data-lng="<?php echo esc_attr($marker['long']); ?>" data-icon-size="<?php echo esc_attr($marker['icon_size']['size']); ?>" data-icon="<?php echo esc_attr($marker['icon']['url']); ?>" data-info-window="<?php echo esc_attr($marker['info_window_onload']); ?>" data-animate="<?php echo esc_attr('animate-' . $settings['animate']) ?>">
                            <?php echo wp_kses_post($marker['address']); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }

}
