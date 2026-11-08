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
        // Without a key the widget falls back to a keyless embed, so the API
        // (which would only paint Google's error box) is not loaded at all.
        return $this->get_api_key() !== '' ? ['gmap-api'] : [];
    }

    protected function get_api_key() {
        $eead_general_settings = get_option('eead_general_settings', []);
        return isset($eead_general_settings['gmap_access_token']) ? trim((string) $eead_general_settings['gmap_access_token']) : '';
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
                'content' => esc_html__('A Google Map API key is needed for multiple markers, custom pins, animation and styles. Without one, a simple embed of the first marker is shown. To add the API key ', 'easy-elementor-addons') . '<a target="_blank" href="' . admin_url('admin.php?page=eead-settings') . '">' . esc_html__('Click Here', 'easy-elementor-addons') . '</a>'
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
                'placeholder' => esc_html__('Enter longitude here', 'easy-elementor-addons')
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
            'title', [
                'label' => esc_html__('Marker Title', 'easy-elementor-addons'),
                'description' => esc_html__('Shown as a tooltip on hover and read out by screen readers.', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
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
                    '{{WRAPPER}} .eead-gmap-markers, {{WRAPPER}} .eead-gmap-embed' => 'height:{{VALUE}}px',
                ]
            ]
        );

        $this->add_control(
            'zoom', [
                'label' => esc_html__('Zoom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 22,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 13,
                ]
            ]
        );

        $this->add_control(
            'map_type_id', [
                'label' => esc_html__('Map Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'roadmap',
                'options' => array(
                    'roadmap' => esc_html__('Roadmap', 'easy-elementor-addons'),
                    'satellite' => esc_html__('Satellite', 'easy-elementor-addons'),
                    'hybrid' => esc_html__('Hybrid', 'easy-elementor-addons'),
                    'terrain' => esc_html__('Terrain', 'easy-elementor-addons'),
                )
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
            'map_id', [
                'label' => esc_html__('Map ID', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block' => true,
                'ai' => ['active' => false],
                'description' => esc_html__('Optional. Overrides the Google Map ID set in the plugin settings. A Map ID enables Advanced Markers. With a Map ID, map styling is done in Google Cloud (Map Styles) and the Snazzy Style option below is ignored.', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'snazzy_style', [
                'label' => esc_html__('Snazzy Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'separator' => 'before',
                /* translators: 1: link start tag, 2: link end tag */
                'description' => sprintf(esc_html__('Choose any map styles by visiting %1$sSnazzy Maps%2$s. Copy any Javascript Style Array and paste here.', 'easy-elementor-addons'), '<a target="_blank" href="https://snazzymaps.com/explore">', '</a>')
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $zoom = !empty($settings['zoom']['size']) ? (int) $settings['zoom']['size'] : 13;

        // A blank or mistyped coordinate would hand Google NaN, which drops the
        // marker and, with several markers, breaks the fit-to-bounds view.
        $markers = array_values(array_filter((array) $settings['markers'], function ($marker) {
            return isset($marker['lat'], $marker['long']) && is_numeric(trim($marker['lat'])) && is_numeric(trim($marker['long'])) && abs((float) $marker['lat']) <= 90 && abs((float) $marker['long']) <= 180;
        }));

        if (empty($markers)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__('Add a marker with a valid latitude and longitude.', 'easy-elementor-addons') . '</div>';
            }
            return;
        }

        if ($this->get_api_key() === '') {
            $this->render_embed($markers[0], $zoom, $settings['map_type_id']);
            return;
        }

        if ($settings['drggable'] === 'no') {
            $this->add_render_attribute('wrapper', [
                'data-gestureHandling' => 'none'
            ]);
        }

        $this->add_render_attribute('wrapper', [
            'data-zoom' => $zoom,
            'data-map-type' => in_array($settings['map_type_id'], ['roadmap', 'satellite', 'hybrid', 'terrain'], true) ? $settings['map_type_id'] : 'roadmap',
            'data-scrollwheel' => $settings['scrollwheel'] == 'enable' ? true : NULL,
            'data-zoomControl' => $settings['zoom_controls'] == 'show' ? true : NULL,
            'data-fullscreenControl' => $settings['fullscreen_control'] == 'show' ? true : NULL,
            'data-streetViewControl' => $settings['street_view'] == 'show' ? true : NULL,
            'data-mapTypeControl' => $settings['map_type'] == 'show' ? true : NULL,
            'data-style' => $settings['snazzy_style'],
            'data-animate' => 'animate-' . $settings['animate']
        ]);

        $map_id = !empty($settings['map_id']) ? trim($settings['map_id']) : '';
        if ($map_id === '') {
            $eead_general_settings = get_option('eead_general_settings', []);
            $map_id = isset($eead_general_settings['gmap_map_id']) ? trim((string) $eead_general_settings['gmap_map_id']) : '';
        }

        if ($map_id !== '') {
            $this->add_render_attribute('wrapper', 'data-map-id', $map_id);
        }
        ?>
        <div class="eead-gmap-container">
            <div class="eead-gmap-markers" <?php $this->print_render_attribute_string('wrapper'); ?>>
                <?php
                foreach ($markers as $marker) {
                    $icon_size = !empty($marker['icon_size']['size']) ? (int) $marker['icon_size']['size'] : 50;
                    ?>
                    <div class="eead-gmap-marker" data-lat="<?php echo esc_attr(trim($marker['lat'])); ?>" data-lng="<?php echo esc_attr(trim($marker['long'])); ?>" data-title="<?php echo esc_attr(isset($marker['title']) ? $marker['title'] : ''); ?>" data-icon-size="<?php echo esc_attr($icon_size); ?>" data-icon="<?php echo esc_url(isset($marker['icon']['url']) ? $marker['icon']['url'] : ''); ?>" data-info-window="<?php echo esc_attr($marker['info_window_onload']); ?>" data-animate="<?php echo esc_attr('animate-' . $settings['animate']) ?>">
                        <?php echo wp_kses_post($marker['address']); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    /** Keyless fallback: Google's plain embed of the first marker. */
    protected function render_embed($marker, $zoom, $map_type) {
        $types = ['roadmap' => 'm', 'satellite' => 'k', 'hybrid' => 'h', 'terrain' => 'p'];
        $src = add_query_arg([
            'q' => trim($marker['lat']) . ',' . trim($marker['long']),
            'z' => $zoom,
            't' => isset($types[$map_type]) ? $types[$map_type] : 'm',
            'output' => 'embed',
        ], 'https://maps.google.com/maps');
        $title = !empty($marker['title']) ? $marker['title'] : esc_html__('Map', 'easy-elementor-addons');
        ?>
        <div class="eead-gmap-container">
            <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?>
                <div class="elementor-alert elementor-alert-info"><?php esc_html_e('No Google Map API key is set, so a simple embed of the first marker is shown. Add a key in the plugin settings for multiple markers, custom pins and map styles.', 'easy-elementor-addons'); ?></div>
            <?php } ?>
            <iframe class="eead-gmap-embed" src="<?php echo esc_url($src); ?>" title="<?php echo esc_attr($title); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
        <?php
    }

}
