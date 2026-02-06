<?php

namespace EasyElementorAddons\Modules\StickyVideo\Widgets;

// Elementor Classes
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Sticky Video Widget
 */
class StickyVideo extends Widget_Base {

    public function get_name() {
        return 'eead-sticky-video';
    }

    public function get_title() {
        return esc_html__('Sticky Video', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-sticky-video';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_style_depends() {
        return ['plyr'];
    }

    public function get_script_depends() {
        return ['plyr'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_video_settings', [
                'label' => esc_html__('Video', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'is_sticky', [
                'label' => esc_html__('Sticky', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'sticky_position', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top-left' => esc_html__('Top Left', 'easy-elementor-addons'),
                    'top-right' => esc_html__('Top Right', 'easy-elementor-addons'),
                    'bottom-left' => esc_html__('Bottom Left', 'easy-elementor-addons'),
                    'bottom-right' => esc_html__('Bottom Right', 'easy-elementor-addons'),
                ],
                'default' => 'bottom-right',
                'condition' => [
                    'is_sticky' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'video_source', [
                'label' => esc_html__('Source', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'easy-elementor-addons'),
                    'vimeo' => esc_html__('Vimeo', 'easy-elementor-addons'),
                    'self_hosted' => esc_html__('Self Hosted', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'link_youtube', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your URL (YouTube)', 'easy-elementor-addons'),
                'label_block' => true,
                'default' => 'https://www.youtube.com/watch?v=MLpWrANjFbI',
                'condition' => [
                    'video_source' => 'youtube',
                ]
            ]
        );

        $this->add_control(
            'link_vimeo', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your URL (Vimeo)', 'easy-elementor-addons'),
                'label_block' => true,
                'default' => 'https://vimeo.com/76979871',
                'condition' => [
                    'video_source' => 'vimeo',
                ]
            ]
        );

        $this->add_control(
            'link_external', [
                'label' => esc_html__('External URL', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'condition' => [
                    'video_source' => 'self_hosted',
                ]
            ]
        );

        $this->add_control(
            'hosted_url', [
                'label' => esc_html__('Choose File', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_source' => 'self_hosted',
                    'link_external' => '',
                ]
            ]
        );

        $this->add_control(
            'external_url', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your URL', 'easy-elementor-addons'),
                'label_block' => true,
                'condition' => [
                    'video_source' => 'self_hosted',
                    'link_external' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'video_self_hosted_link', [
                'label' => esc_html__('Choose File', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'condition' => [
                    'video_source' => 'self_hosted',
                    'video_source_external' => '',
                ]
            ]
        );

        $this->add_control(
            'autoplay', [
                'label' => esc_html__('Autoplay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'mute', [
                'label' => esc_html__('Mute', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false
            ]
        );

        $this->add_control(
            'loop', [
                'label' => esc_html__('Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false
            ]
        );

        $this->add_control(
            'show_bar', [
                'label' => esc_html__('Show Control Bar', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .plyr__controls' => 'display: flex;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'video_image_overlay_section', [
                'label' => esc_html__('Video Poster', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'overlay_options', [
                'label' => esc_html__('Poster Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'label_on' => esc_html__('Show', 'easy-elementor-addons'),
                'label_off' => esc_html__('Hide', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'overlay_image', [
                'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'condition' => [
                    'overlay_options' => 'yes',
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'default' => 'full',
                'name' => 'overlay_image_size',
                'condition' => [
                    'overlay_options' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'overlay_play_icon', [
                'label' => esc_html__('Show Play Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'default' => 'yes',
                'condition' => [
                    'overlay_options' => 'yes',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'player_interface_section', [
                'label' => esc_html__('Video Interface', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'video_interface_color', [
                'label' => esc_html__('Interface Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7b6ccc',
                'selectors' => [
                    '{{WRAPPER}}' => '--plyr-color-main: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'play_button_size', [
                'label' => esc_html__('Play Button Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 25,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 55,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .plyr__control--overlaid, {{WRAPPER}} .eead-overlay-icon' => 'padding: {{SIZE}}{{UNIT}}; height: auto',
                    '{{WRAPPER}} .plyr__control--overlaid svg, {{WRAPPER}} .eead-overlay-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'player_bar_padding', [
                'label' => esc_html__('Control Bar Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .plyr--video .plyr__controls' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sticky_video_interface', [
                'label' => esc_html__('Sticky Video', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'is_sticky' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'sticky_width', [
                'label' => esc_html__('Sticky Video Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 400,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video' => '--eead-sticky-video-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_close_button_bg_color', [
                'label' => esc_html__('Close Button Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-player-close' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'sticky_close_button_icon_color', [
                'label' => esc_html__('Close Button Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-player-close:before, {{WRAPPER}} .eead-sticky-player-close:after' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'player_section', [
                'label' => esc_html__('Player', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'video_width', [
                'label' => esc_html__('Video Max Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'video_border_type', [
                'label' => esc_html__('Border Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'solid' => esc_html__('Solid', 'easy-elementor-addons'),
                    'double' => esc_html__('Double', 'easy-elementor-addons'),
                    'dotted' => esc_html__('Dotted', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video-container' => 'border-style: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'video_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'video_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video-container' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'video_shadow',
                'selector' => '{{WRAPPER}} .eead-sticky-video-container'
            ]
        );

        $this->add_responsive_control(
            'video_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-sticky-video-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $sticky = isset($settings['is_sticky']) && $settings['is_sticky'] == 'yes' ? $settings['is_sticky'] : 'no';
        $autoplay = isset($settings['autoplay']) && $settings['autoplay'] == 'yes' ? 'true' : 'false';
        $muted = isset($settings['mute']) && $settings['mute'] == 'yes' ? 'true' : 'false';
        $loop = isset($settings['loop']) && $settings['loop'] == 'yes' ? 'true' : 'false';
        $overlay = isset($settings['overlay_options']) && $settings['overlay_options'] == 'yes' ? $settings['overlay_options'] : 'no';
        ?>
        <div class="eead-sticky-video-container">
            <?php

            $this->add_render_attribute(
                'video_wrapper', [
                    'class' => 'eead-sticky-video',
                    'data-sticky' => esc_attr($sticky),
                    'data-position' => esc_attr($settings['sticky_position']),
                    'data-autoplay' => esc_attr($autoplay),
                    'data-overlay' => esc_attr($overlay),
                    'data-mute' => esc_attr($muted),
                    'data-loop' => esc_attr($loop)
                ]
            );
            ?>
            <div <?php $this->print_render_attribute_string('video_wrapper'); ?>>
                <?php
                if ('youtube' == $settings['video_source']) {
                    echo wp_kses_post($this->get_youtube_player());
                }

                if ('vimeo' == $settings['video_source']) {
                    echo wp_kses_post($this->get_vimeo_player());
                }

                if ('self_hosted' == $settings['video_source']) {
                    echo wp_kses_post($this->get_self_hosted_player());
                }
                ?>
                <span class="eead-sticky-player-close"></span>
            </div>
            <?php
            if ('yes' === $settings['overlay_options']) {
                $this->add_render_attribute(
                    'overlay_wrapper', [
                        'class' => 'eead-overlay',
                        'style' => "background-image:url('" . esc_url($settings['overlay_image']['url']) . "');",
                    ]
                );
                ?>

                <div <?php $this->print_render_attribute_string('overlay_wrapper'); ?>>
                    <div class="eead-overlay-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#FFF" viewBox="2 0 14 18">
                            <path d="M15.562 8.1L3.87.225c-.818-.562-1.87 0-1.87.9v15.75c0 .9 1.052 1.462 1.87.9L15.563 9.9c.584-.45.584-1.35 0-1.8z" />
                        </svg>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

    protected function get_youtube_player() {
        $id = $this->get_url_id();

        return '<div id="eead-player-' . esc_attr($this->get_id()) . '"
            data-plyr-provider="youtube"
            data-plyr-embed-id="' . esc_attr($id) . '">
            </div>';
    }

    protected function get_vimeo_player() {
        $id = $this->get_url_id();

        return '<div id="eead-player-' . esc_attr($this->get_id()) . '"
            data-plyr-provider="vimeo"
            data-plyr-embed-id="' . esc_attr($id) . '">
            </div>';
    }

    protected function get_self_hosted_player() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $video = ($settings['link_external'] == 'yes') ? $settings['external_url'] : $settings['hosted_url']['url'];

        ob_start();
        ?>
        <video src="<?php echo esc_url($video); ?>" id="eead-player-<?php echo esc_attr($id); ?>" playsinline controls>
            <source src="<?php echo esc_url($video); ?>" type="video/mp4">
            <?php echo esc_html__('Your browser does not support the video tag.', 'easy-elementor-addons'); ?>
        </video>
        <?php
        return ob_get_clean();
    }

    protected function get_url_id() {
        $settings = $this->get_settings_for_display();

        if ($settings['video_source'] === 'youtube') {
            $url = $settings['link_youtube'];
            $link = explode('=', wp_parse_url($url, PHP_URL_QUERY));
            $id = $link[1];
        } else if ($settings['video_source'] === 'vimeo') {
            $url = $settings['link_vimeo'];
            $link = explode('/', $url);
            $id = $link[3];
        }

        return $id;
    }

}
