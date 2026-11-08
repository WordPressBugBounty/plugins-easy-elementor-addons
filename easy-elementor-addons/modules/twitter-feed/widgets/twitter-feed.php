<?php

namespace EasyElementorAddons\Modules\TwitterFeed\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class TwitterFeed extends Widget_Base {

    public function get_name() {
        return 'eead-twitter-feed';
    }

    public function get_title() {
        return esc_html__('Twitter Feed', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-twitter-x';
    }

    public function get_keywords() {
        return ['twitter', 'tweet', 'x', 'feed', 'eead'];
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
        return ['twitter-widgets'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_main', [
                'label' => esc_html__('Main Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'embed_type', [
                'label' => esc_html__('Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hashtag',
                'options' => [
                    'hashtag' => esc_html__('Hashtag', 'easy-elementor-addons'),
                    'post' => esc_html__('Post', 'easy-elementor-addons'),
                    'video' => esc_html__('Video', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'url_post', [
                'label' => esc_html__('Enter URL', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://twitter.com/SpaceX/status/1732824684683784516',
                'default' => 'https://twitter.com/SpaceX/status/1732824684683784516',
                'condition' => [
                    'embed_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'url_video', [
                'label' => esc_html__('Enter URL', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://twitter.com/SpaceX/status/1732824684683784516',
                'default' => 'https://twitter.com/SpaceX/status/1732824684683784516',
                'condition' => [
                    'embed_type' => 'video',
                ]
            ]
        );

        $this->add_control(
            'width_max_video', [
                'label' => esc_html__('Video Width', 'easy-elementor-addons') . ' (px)',
                'type' => Controls_Manager::NUMBER,
                'default' => 560,
                'min' => 100,
                'max' => 1000,
                'condition' => [
                    'embed_type' => 'video',
                ]
            ]
        );

        $this->add_control(
            'hashtag', [
                'label' => esc_html__('Enter Hashtag', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '#hashtag',
                'condition' => [
                    'embed_type' => 'hashtag',
                ]
            ]
        );

        $this->add_control(
            'theme_post', [
                'label' => esc_html__('Theme', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'light',
                'options' => [
                    'light' => esc_html__('Light', 'easy-elementor-addons'),
                    'dark' => esc_html__('Dark', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'embed_type' => ['post', 'video'],
                ]
            ]
        );

        $this->add_control(
            'hide_thread', [
                'label' => esc_html__('Hide Parent Post', 'easy-elementor-addons'),
                'description' => esc_html__('For replies, show only the reply, not the post it answers.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'embed_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'hide_media', [
                'label' => esc_html__('Hide Photos, Videos and Link Cards', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'embed_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'post_width', [
                'label' => esc_html__('Max Width', 'easy-elementor-addons') . ' (px)',
                'description' => esc_html__('Between 250 and 550. Leave empty for the default.', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 250,
                'max' => 550,
                'condition' => [
                    'embed_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'post_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
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
                    ],
                ],
                'condition' => [
                    'embed_type' => ['post', 'video'],
                ]
            ]
        );

        $prefill_options = [
            'post_title' => esc_html__('Post Title', 'easy-elementor-addons'),
            'excerpt' => esc_html__('Post Excerpt', 'easy-elementor-addons'),
            'custom' => esc_html__('Custom', 'easy-elementor-addons')
        ];
        $this->add_control(
            'prefill_text_hashtag', [
                'label' => esc_html__('Pre Fill Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_title',
                'options' => $prefill_options,
                'condition' => [
                    'embed_type' => 'hashtag',
                ],
                'description' => esc_html__('Do you want to prefill the Tweet text?', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'prefill_custom', [
                'label' => esc_html__('Custom Prefill Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'condition' => [
                    'prefill_text_hashtag' => 'custom',
                    'embed_type' => 'hashtag',
                ]
            ]
        );

        $this->add_control(
            'hashtag_url', [
                'label' => esc_html__('Fix Url in Tweet', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Do you want to set a specific URL in the Tweet?', 'easy-elementor-addons'),
                'condition' => [
                    'embed_type' => 'hashtag',
                ]
            ]
        );

        $this->add_control(
            'language', [
                'label' => esc_html__('Language', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->languages()
            ]
        );

        $this->add_control(
            'hashtag_large_button', [
                'label' => esc_html__('Large Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'embed_type' => 'hashtag',
                ]
            ]
        );

        $this->add_control(
            'dnt', [
                'label' => esc_html__('Privacy Mode', 'easy-elementor-addons'),
                'description' => esc_html__('Asks X not to use this page visit to personalise ads or suggestions (Do Not Track).', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    public function languages() {
        $languages = [
            '' => esc_html__('Automatic', 'easy-elementor-addons'),
            'en' => esc_html__('English', 'easy-elementor-addons'),
            'ar' => esc_html__('Arabic', 'easy-elementor-addons'),
            'bn' => esc_html__('Bengali', 'easy-elementor-addons'),
            'cs' => esc_html__('Czech', 'easy-elementor-addons'),
            'da' => esc_html__('Danish', 'easy-elementor-addons'),
            'de' => esc_html__('German', 'easy-elementor-addons'),
            'el' => esc_html__('Greek', 'easy-elementor-addons'),
            'es' => esc_html__('Spanish', 'easy-elementor-addons'),
            'fa' => esc_html__('Persian', 'easy-elementor-addons'),
            'fi' => esc_html__('Finnish', 'easy-elementor-addons'),
            'fil' => esc_html__('Filipino', 'easy-elementor-addons'),
            'fr' => esc_html__('French', 'easy-elementor-addons'),
            'he' => esc_html__('Hebrew', 'easy-elementor-addons'),
            'hi' => esc_html__('Hindi', 'easy-elementor-addons'),
            'hu' => esc_html__('Hungarian', 'easy-elementor-addons'),
            'id' => esc_html__('Indonesian', 'easy-elementor-addons'),
            'it' => esc_html__('Italian', 'easy-elementor-addons'),
            'ja' => esc_html__('Japanese', 'easy-elementor-addons'),
            'ko' => esc_html__('Korean', 'easy-elementor-addons'),
            'msa' => esc_html__('Malay', 'easy-elementor-addons'),
            'nl' => esc_html__('Dutch', 'easy-elementor-addons'),
            'no' => esc_html__('Norwegian', 'easy-elementor-addons'),
            'pl' => esc_html__('Polish', 'easy-elementor-addons'),
            'pt' => esc_html__('Portuguese', 'easy-elementor-addons'),
            'ro' => esc_html__('Romania', 'easy-elementor-addons'),
            'ru' => esc_html__('Rus', 'easy-elementor-addons'),
            'sv' => esc_html__('Swedish', 'easy-elementor-addons'),
            'th' => esc_html__('Thai', 'easy-elementor-addons'),
            'tr' => esc_html__('Turkish', 'easy-elementor-addons'),
            'uk' => esc_html__('Ukrainian', 'easy-elementor-addons'),
            'ur' => esc_html__('Urdu', 'easy-elementor-addons'),
            'vi' => esc_html__('Vietnamese', 'easy-elementor-addons'),
            'zh-cn' => esc_html__('Chinese (Simplified)', 'easy-elementor-addons'),
            'zh-tw' => esc_html__('Chinese (Traditional)', 'easy-elementor-addons'),
        ];

        return $languages;
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        if ($settings['embed_type'] == 'hashtag') {
            $this->get_hashtag_html($settings);
        } else if ($settings['embed_type'] == 'post') {
            $this->get_post_html($settings);
        } else if ($settings['embed_type'] == 'video') {
            $this->get_video_html($settings);
        }
    }

    /** Attributes shared by every embed type; empty values are left out. */
    protected function common_attributes($key, $settings) {
        if (!empty($settings['language'])) {
            $this->add_render_attribute($key, 'data-lang', $settings['language']);
        }
        if ('yes' === $settings['dnt']) {
            $this->add_render_attribute($key, 'data-dnt', 'true');
        }
    }

    /** Shown in the editor when the widget has nothing to embed. */
    protected function editor_notice($message) {
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="elementor-alert elementor-alert-info">' . esc_html($message) . '</div>';
        }
    }

    /**
     * The embed is a link until widgets.js turns it into a card, so it stays
     * usable if the script is blocked (ad blockers, cookie consent tools).
     */
    protected function print_tweet_blockquote($url, $label) {
        ?>
        <blockquote <?php $this->print_render_attribute_string('blockquote'); ?>><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a></blockquote>
        <?php
    }

    public function get_video_html($settings) {
        $url = trim((string) $settings['url_video']);
        if ('' === $url) {
            $this->editor_notice(esc_html__('Enter the URL of an X post with a video.', 'easy-elementor-addons'));
            return;
        }

        $this->add_render_attribute('blockquote', [
            'class' => 'twitter-tweet',
            'data-theme' => $settings['theme_post'],
        ]);
        if (!empty($settings['width_max_video'])) {
            $this->add_render_attribute('blockquote', 'data-media-max-width', absint($settings['width_max_video']));
        }
        if (!empty($settings['post_align'])) {
            $this->add_render_attribute('blockquote', 'data-align', $settings['post_align']);
        }
        $this->common_attributes('blockquote', $settings);

        $this->print_tweet_blockquote($url, esc_html__('Watch the video on X', 'easy-elementor-addons'));
    }

    public function get_post_html($settings) {
        $url = trim((string) $settings['url_post']);
        if ('' === $url) {
            $this->editor_notice(esc_html__('Enter the URL of an X post.', 'easy-elementor-addons'));
            return;
        }

        $this->add_render_attribute('blockquote', [
            'class' => 'twitter-tweet',
            'data-theme' => $settings['theme_post'],
        ]);
        if ('yes' === $settings['hide_thread']) {
            $this->add_render_attribute('blockquote', 'data-conversation', 'none');
        }
        if ('yes' === $settings['hide_media']) {
            $this->add_render_attribute('blockquote', 'data-cards', 'hidden');
        }
        if (!empty($settings['post_width'])) {
            $this->add_render_attribute('blockquote', 'data-width', max(250, min(550, absint($settings['post_width']))));
        }
        if (!empty($settings['post_align'])) {
            $this->add_render_attribute('blockquote', 'data-align', $settings['post_align']);
        }
        $this->common_attributes('blockquote', $settings);

        $this->print_tweet_blockquote($url, esc_html__('View the post on X', 'easy-elementor-addons'));
    }

    public function get_hashtag_html($settings) {
        $hashtag = trim(ltrim(trim((string) $settings['hashtag']), '#'));
        if ('' === $hashtag) {
            $this->editor_notice(esc_html__('Enter a hashtag.', 'easy-elementor-addons'));
            return;
        }

        $this->add_render_attribute('hashtag', [
            'class' => 'twitter-hashtag-button',
            'href' => 'https://x.com/intent/tweet?button_hashtag=' . rawurlencode($hashtag),
        ]);
        $this->common_attributes('hashtag', $settings);

        $text = '';
        if ($settings['prefill_text_hashtag'] === 'post_title') {
            $text = $this->current_post_title();
        } elseif ($settings['prefill_text_hashtag'] === 'excerpt') {
            $text = $this->current_post_excerpt();
        } elseif ($settings['prefill_text_hashtag'] === 'custom') {
            $text = $settings['prefill_custom'];
        }
        $text = html_entity_decode(wp_strip_all_tags((string) $text), ENT_QUOTES, 'UTF-8');
        if ('' !== trim($text)) {
            $this->add_render_attribute('hashtag', 'data-text', $text);
        }

        if ($settings['hashtag_large_button'] === 'yes') {
            $this->add_render_attribute('hashtag', 'data-size', 'large');
        }
        if ('' !== trim((string) $settings['hashtag_url'])) {
            $this->add_render_attribute('hashtag', 'data-url', esc_url_raw(trim($settings['hashtag_url'])));
        }
        ?>
        <a <?php $this->print_render_attribute_string('hashtag'); ?>><?php
            /* translators: %s: hashtag */
            echo esc_html(sprintf(__('Tweet %s', 'easy-elementor-addons'), '#' . $hashtag));
            ?></a>
        <?php
    }

    /** The page being viewed, not the first post of an archive loop. */
    protected function current_object_id() {
        return is_singular() ? get_queried_object_id() : 0;
    }

    public function current_post_title() {
        $id = $this->current_object_id();
        return $id ? get_the_title($id) : wp_get_document_title();
    }

    public function current_post_excerpt() {
        $id = $this->current_object_id();
        return $id && has_excerpt($id) ? get_the_excerpt($id) : '';
    }

}
