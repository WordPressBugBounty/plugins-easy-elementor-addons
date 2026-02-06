<?php

namespace EasyElementorAddons\Modules\VideoPlayer\Widgets;

// Elementor Classes
use Elementor\Embed;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class VideoPlayer extends Widget_Base {

    public function get_name() {
        return 'eead-video-player';
    }

    public function get_script_depends() {
        return array();
    }

    public function get_title() {
        return esc_html__('Video Player', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-video-player';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_video', [
                'label' => esc_html__('Video', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'video_type', [
                'label' => esc_html__('Video Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'easy-elementor-addons'),
                    'vimeo' => esc_html__('Vimeo', 'easy-elementor-addons'),
                    'self_hosted' => esc_html__('Self Hosted', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'youtube_url', [
                'label' => esc_html__('Youtube URL', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your URL', 'easy-elementor-addons'),
                'default' => 'https://www.youtube.com/watch?v=MLpWrANjFbI',
                'condition' => [
                    'video_type' => 'youtube',
                ]
            ]
        );

        $this->add_control(
            'vimeo_url', [
                'label' => esc_html__('Vimeo URL', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your URL', 'easy-elementor-addons'),
                'default' => 'https://vimeo.com/76979871',
                'condition' => [
                    'video_type' => 'vimeo',
                ]
            ]
        );

        $this->add_control(
            'self_hosted_url', [
                'label' => esc_html__('Self Hosted Video', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'self_hosted',
                ]
            ]
        );

        $this->add_control(
            'start_time', [
                'label' => esc_html__('Start Time (seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'loop' => '',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'end_time', [
                'label' => esc_html__('End Time (seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'loop' => '',
                    'video_type' => ['youtube', 'self_hosted']
                ],
            ]
        );

        $this->add_control(
            'aspect_ratio', [
                'label' => esc_html__('Aspect Ratio', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '16-9',
                'options' => [
                    '16-9' => '16:9',
                    '21-9' => '21:9',
                    '9-16' => '9:16',
                    '4-3' => '4:3',
                    '3-2' => '3:2',
                    '1-1' => '1:1',
                ],
                'condition' => [
                    'video_type' => ['youtube', 'vimeo'],
                ]
            ]
        );

        $this->add_control(
            'controls', [
                'label' => esc_html__('Show Player Controls', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'video_type!' => 'vimeo',
                ]
            ]
        );

        $this->add_control(
            'autoplay', [
                'label' => esc_html__('Autoplay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'loop', [
                'label' => esc_html__('Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );

        $this->add_control(
            'mute', [
                'label' => esc_html__('Mute', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );

        $this->add_control(
            'download_button', [
                'label' => esc_html__('Download Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'video_type' => 'self_hosted',
                    'controls' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'vimeo_controls_color', [
                'label' => esc_html__('Controls Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'alpha' => false,
                'condition' => [
                    'video_type' => 'vimeo',
                ]
            ]
        );

        $this->add_control(
            'yt_setting_header', [
                'label' => esc_html__('Youtube Options', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'video_type' => 'youtube',
                ]
            ]
        );

        $this->add_control(
            'yt_modestbranding', [
                'label' => esc_html__('Modest Branding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'video_type' => 'youtube',
                    'controls' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'yt_privacy_mode', [
                'label' => esc_html__('Privacy Mode', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('If switched off, YouTube will save visitors data on your website only when video is played.', 'easy-elementor-addons'),
                'condition' => [
                    'video_type' => 'youtube',
                ]
            ]
        );

        $this->add_control(
            'yt_suggested_videos', [
                'label' => esc_html__('Suggested Videos', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Current Video Channel', 'easy-elementor-addons'),
                    'yes' => esc_html__('Any Video', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'video_type' => 'youtube',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'play_button_section', [
                'label' => esc_html__('Play Button', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'show_play_button', [
                'label' => esc_html__('Show Play Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'play_button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'eicon-play-o',
                ],
                'condition' => [
                    'show_play_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'play_button_size', [
                'label' => esc_html__('Button Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-video-play-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-video-play-button svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_play_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'play_button_color', [
                'label' => esc_html__('Play Button Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-video-play-button i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-video-play-button svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'show_play_button' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'poster_image_section', [
                'label' => esc_html__('Poster Image', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'show_thumbnail', [
                'label' => esc_html__('Show Custom Poster', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'thumbnail', [
                'label' => esc_html__('Upload Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'show_thumbnail' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail',
                'default' => 'full',
                'condition' => [
                    'show_thumbnail' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'overlay_color', [
                'label' => esc_html__('Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-video-overlay:before' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $video_url = $this->get_video_url();
        if (!$video_url) {
            return;
        }

        $settings = $this->get_settings_for_display();
        $data_settings = json_encode([
            'autoplay' => filter_var($settings['autoplay'], FILTER_VALIDATE_BOOLEAN),
        ]);

        $this->add_render_attribute('video-player', [
            'class' => 'eead-video-player',
            'data-settings' => esc_attr($data_settings)
        ]);

        if ($settings['aspect_ratio']) {
            $this->add_render_attribute('video-player', [
                'class' => 'eead-video-aspect-ratio-' . esc_attr($settings['aspect_ratio']),
            ]);
        }
        ?>
        <div class="eead-video-player-container">
            <div <?php $this->print_render_attribute_string('video-player'); ?>>
                <?php
                $this->get_video_block();
                $this->get_overlay();
                ?>
            </div>
        </div>
        <?php
    }

    protected function get_overlay() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('overlay', [
            'class' => 'eead-video-overlay'
        ]);

        $thumb_url = $this->get_thumbnail_url();

        if ($thumb_url) {
            $this->add_render_attribute('overlay', [
                'style' => sprintf('background-image: url(%s);', esc_url($thumb_url))
            ]);
        }
        ?>

        <div <?php $this->print_render_attribute_string('overlay'); ?>>
            <?php
            if ($settings['show_play_button'] == 'yes') {
                $this->get_play_button();
            }
            ?>
        </div>
        <?php
    }

    protected function get_play_button() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('play_button', [
            'class' => 'eead-video-play-button',
            'role' => 'button'
        ]);
        ?>

        <div <?php $this->print_render_attribute_string('play_button'); ?>>
            <?php
            Icons_Manager::render_icon($settings['play_button_icon'], ['aria-hidden' => 'true']);
            ?>
        </div>
        <?php
    }

    protected function get_video_block() {
        $settings = $this->get_settings_for_display();
        $video_url = $this->get_video_url();

        if ($settings['video_type'] === 'self_hosted') {
            $self_hosted_params = $this->get_self_hosted_params();

            $this->add_render_attribute('video_player', 'class', 'eead-html-video-player');
            $this->add_render_attribute('video_player', 'src', $video_url);
            $this->add_render_attribute('video_player', $self_hosted_params);

            if ($settings['show_play_button'] == 'yes') {
                $this->add_render_attribute('video_player', 'class', 'eead-custom-play-button');
            }

            echo wp_kses_post('<video ' . $this->get_render_attribute_string('video_player') . '></video>');
        } else {
            $embed_params = $this->get_embed_params();
            $embed_options = $this->get_embed_options();

            $embed_attr = [
                'class' => 'eead-video-iframe',
                'allow' => 'autoplay;encrypted-media'
            ];

            $allowed_tags = [
                'iframe' => [
                    'src' => true,
                    'width' => true,
                    'height' => true,
                    'frameborder' => true,
                    'allow' => true,
                    'allowfullscreen' => true,
                    'data-lazy-load' => true,
                    'title' => true,
                    'class' => true
                ],
                'div' => [
                    'class' => true,
                    'style' => true,
                ],
            ];

            echo wp_kses(Embed::get_embed_html($video_url, $embed_params, $embed_options, $embed_attr), $allowed_tags);
        }
    }

    public function get_embed_params() {
        $settings = $this->get_settings_for_display();
        $params = array();
        $params_dictionary = array();

        if ($settings['video_type'] == 'youtube') {
            $params_dictionary = [
                'autoplay' => 'autoplay',
                'loop' => 'loop',
                'controls' => 'controls',
                'mute' => 'mute',
                'yt_suggested_videos' => 'rel',
                'yt_modestbranding' => 'modestbranding'
            ];

            if ($settings['loop']) {
                $video_properties = Embed::get_video_properties(esc_url($settings['youtube_url']));
                $params['playlist'] = $video_properties['video_id'];
            }

            $params['wmode'] = 'opaque';
            $params['start'] = $settings['start_time'];
            $params['end'] = $settings['end_time'];
        } else if ($settings['video_type'] == 'vimeo') {
            $params_dictionary = [
                'autoplay' => 'autoplay',
                'loop' => 'loop',
                'mute' => 'muted'
            ];

            if (!empty($settings['vimeo_controls_color'])) {
                $params['color'] = str_replace('#', '', $settings['vimeo_controls_color']);
            }
            $params['autopause'] = '0';
        }

        foreach ($params_dictionary as $setting_name => $param_name) {
            $param_value = $settings[$setting_name] == 'yes' ? '1' : '0';
            $params[$param_name] = $param_value;
        }

        return $params;
    }

    public function get_embed_options() {
        $settings = $this->get_settings_for_display();
        $embed_settings = [];

        if ($settings['video_type'] == 'youtube') {
            $embed_settings['privacy'] = $settings['yt_privacy_mode'] == 'yes' ? true : NULL;
        } else if ($settings['video_type'] == 'vimeo') {
            $embed_settings['start'] = $settings['start_time'];
        }

        $thumb_url = $this->get_thumbnail_url();
        $embed_settings['lazy_load'] = !empty($thumb_url);
        return $embed_settings;
    }

    public function get_thumbnail_url() {
        $settings = $this->get_settings_for_display();
        $thumb_url = '';
        $has_thumb = !empty($settings['thumbnail']['url']) && filter_var($settings['show_thumbnail'], FILTER_VALIDATE_BOOLEAN);

        if ($has_thumb) {
            $thumb_url = Group_Control_Image_Size::get_attachment_image_src($settings['thumbnail']['id'], 'thumbnail', $settings);
        } else if (in_array($settings['video_type'], ['youtube', 'vimeo'])) {
            $thumb_url = $this->get_iframe_thumbnail_url($this->get_video_url());
        }

        if (empty($thumb_url)) {
            return '';
        }

        return esc_url($thumb_url);
    }

    public function get_iframe_thumbnail_url($url) {
        $settings = $this->get_settings_for_display();
        $oembed = _wp_oembed_get_object();
        $data = $oembed->get_data($url);
        $thumb_url = $data->thumbnail_url;

        if ($settings['video_type'] === 'youtube') {
            $url_fetch = explode("v=", $url);
            $videoid = $url_fetch[1];
            $thumb_url = 'http://img.youtube.com/vi/' . $videoid . '/maxresdefault.jpg';
        }

        return esc_url($thumb_url);
    }

    public function get_self_hosted_params() {
        $settings = $this->get_settings_for_display();
        $params = array();
        $options = ['autoplay', 'loop', 'controls'];

        foreach ($options as $param_name) {
            if ($settings[$param_name] == 'yes') {
                $params[$param_name] = '';
            }
        }

        if ($settings['mute'] == 'yes') {
            $params['muted'] = '';
        }

        if ($settings['download_button'] != 'yes') {
            $params['controlsList'] = 'nodownload';
        }

        return $params;
    }

    protected function get_video_url() {
        $settings = $this->get_settings_for_display();
        $video_url = '';
        if ($settings['video_type'] == 'self_hosted' && $settings['self_hosted_url']['url']) {
            $video_url = $settings['self_hosted_url']['url'];
            if ($settings['start_time'] || $settings['end_time']) {
                $video_url .= '#t=';
                if ($settings['start_time']) {
                    $video_url .= $settings['start_time'];
                }

                if ($settings['end_time']) {
                    $video_url .= ',' . $settings['end_time'];
                }
            }
        } else {
            $video_url = $settings[$settings['video_type'] . '_url'];
        }

        return esc_url($video_url);
    }

}
