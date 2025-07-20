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

    public function get_categories() {
        return ['easy-elementor-addons'];
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
                'default' => 'handle',
                'options' => [
                    'handle' => esc_html__('Handle', 'easy-elementor-addons'),
                    'hashtag' => esc_html__('Hashtag', 'easy-elementor-addons'),
                    'post' => esc_html__('Post', 'easy-elementor-addons'),
                    'video' => esc_html__('Video', 'easy-elementor-addons'),
                    'profile' => esc_html__('Profile', 'easy-elementor-addons'),
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
            'url_profile', [
                'label' => esc_html__('Enter URL', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://twitter.com/SpaceX',
                'default' => 'https://twitter.com/SpaceX',
                'condition' => [
                    'embed_type' => 'profile',
                ]
            ]
        );

        $this->add_control(
            'username', [
                'label' => esc_html__('Enter UserName', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => '@username',
                'default' => '@x',
                'condition' => [
                    'embed_type' => 'handle',
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
                    'embed_type' => 'post',
                ]
            ]
        );

        $this->add_control(
            'display_mode_profile', [
                'label' => esc_html__('Display Mode', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'timeline',
                'options' => [
                    'timeline' => esc_html__('Timeline', 'easy-elementor-addons'),
                    'button' => esc_html__('Button', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'embed_type' => ['profile', 'handle'],
                ]
            ]
        );

        $this->add_control(
            'height_profile_timeline', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 250,
                        'max' => 1300,
                        'step' => 10,
                    ]
                ],
                'condition' => [
                    'display_mode_profile' => 'timeline',
                    'embed_type' => ['profile', 'handle'],
                ]
            ]
        );

        $this->add_control(
            'theme_profile_timeline', [
                'label' => esc_html__('Theme', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'light',
                'options' => [
                    'light' => esc_html__('Light', 'easy-elementor-addons'),
                    'dark' => esc_html__('Dark', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'display_mode_profile' => 'timeline',
                    'embed_type' => ['profile', 'handle'],
                ]
            ]
        );

        $this->add_control(
            'button_type', [
                'label' => esc_html__('Button Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'follow-button',
                'options' => [
                    'follow-button' => esc_html__('Follow', 'easy-elementor-addons'),
                    'mention-button' => esc_html__('Mention', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'display_mode_profile' => 'button',
                    'embed_type' => ['profile', 'handle'],
                ]
            ]
        );

        $this->add_control(
            'hide_name', [
                'label' => esc_html__('Hide Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'easy-elementor-addons'),
                'label_off' => esc_html__('Hide', 'easy-elementor-addons'),
                'condition' => [
                    'display_mode_profile' => 'button',
                    'button_type' => 'follow-button',
                    'embed_type' => ['profile', 'handle'],
                ]
            ]
        );

        $this->add_control(
            'show_count', [
                'label' => esc_html__('Show Count', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Show', 'easy-elementor-addons'),
                'label_off' => esc_html__('Hide', 'easy-elementor-addons'),
                'condition' => [
                    'embed_type' => ['profile', 'handle'],
                    'display_mode_profile' => 'button',
                    'button_type' => 'follow-button',
                ]
            ]
        );

        $this->add_control(
            'prefill_text', [
                'label' => esc_html__('Tweet Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Do you want to prefill the Tweet text?', 'easy-elementor-addons'),
                'condition' => [
                    'embed_type' => ['profile', 'handle'],
                    'display_mode_profile' => 'button',
                    'button_type' => 'mention-button',
                ]
            ]
        );

        $this->add_control(
            'screen_name', [
                'label' => esc_html__('Screen Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'embed_type' => ['profile', 'handle'],
                    'display_mode_profile' => 'button',
                    'button_type' => 'mention-button',
                ]
            ]
        );

        $this->add_control(
            'large_button', [
                'label' => esc_html__('Large Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'embed_type' => ['profile', 'handle'],
                    'display_mode_profile' => 'button',
                ]
            ]
        );

        $prefill_options = [];
        if (is_single()) {
            $prefill_options = [
                'post_title' => esc_html__('Post Title', 'easy-elementor-addons'),
                'excerpt' => esc_html__('Post Excerpt', 'easy-elementor-addons')
            ];
        }

        $prefill_options['custom'] = 'Custom';
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
        if ($settings['embed_type'] == 'handle') {
            $this->get_handle_html($settings);
        } else if ($settings['embed_type'] == 'hashtag') {
            $this->get_hashtag_html($settings);
        } else if ($settings['embed_type'] == 'post') {
            $this->get_post_html($settings);
        } else if ($settings['embed_type'] == 'video') {
            $this->get_video_html($settings);
        } else if ($settings['embed_type'] == 'profile') {
            $this->get_profile_html($settings);
        }
        ?>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <?php
    }

    public function get_video_html($settings) {
        $this->add_render_attribute('blockquote', [
            'class' => 'twitter-tweet',
            'data-media-max-width' => $settings['width_max_video'],
            'data-lang' => $settings['language'],
        ]);

        $this->add_render_attribute('video', [
            'href' => $settings['url_video'],
        ]);
        ?>
        <blockquote <?php $this->print_render_attribute_string('blockquote'); ?>><a <?php $this->print_render_attribute_string('video'); ?>></a></blockquote>
        <?php
    }

    public function get_post_html($settings) {
        $this->add_render_attribute('blockquote', [
            'class' => 'twitter-tweet',
            'data-lang' => $settings['language'],
            'data-theme' => $settings['theme_post'],
        ]);

        $this->add_render_attribute('post', [
            'href' => $settings['url_post']
        ]);
        ?>
        <blockquote <?php $this->print_render_attribute_string('blockquote'); ?>><a <?php $this->print_render_attribute_string('post'); ?>></a></blockquote>
        <?php
    }

    public function get_profile_html($settings) {
        $this->add_render_attribute('profile', [
            'href' => $settings['url_profile'],
            'data-lang' => $settings['language']
        ]);

        if ($settings['large_button'] === 'yes') {
            $this->add_render_attribute('profile', 'data-size', 'large');
        }

        if ($settings['display_mode_profile'] === 'timeline') {
            $this->add_render_attribute('profile', [
                'class' => 'twitter-' . $settings['display_mode_profile'],
                'data-partner' => 'twitter-deck',
                'data-height' => $settings['height_profile_timeline']['size'],
                'data-theme' => $settings['theme_profile_timeline']
            ]);
        }

        if ($settings['display_mode_profile'] === 'button' && $settings['button_type'] === 'follow-button') {
            $this->add_render_attribute('profile', 'class', 'twitter-' . $settings['button_type']);
            if ($settings['hide_name'] === 'yes') {
                $this->add_render_attribute('profile', 'data-show-screen-name', 'false');
            }

            if ($settings['show_count'] === '') {
                $this->add_render_attribute('profile', 'data-show-count', 'false');
            }
        }

        if ($settings['display_mode_profile'] === 'button' && $settings['button_type'] === 'mention-button') {
            $this->add_render_attribute('profile', [
                'class' => 'twitter-' . $settings['button_type'],
                'data-text' => $settings['prefill_text'],
                'href' => $settings['url_profile'] . '?screen_name=' . $settings['screen_name']
            ]);
        }
        ?>
        <a <?php $this->print_render_attribute_string('profile'); ?>></a>
        <?php
    }

    public function get_list_html($settings) {
        if ($settings['embed_type'] === 'list') {
            $this->add_render_attribute('list', 'class', 'twitter-timeline');
        }

        $this->add_render_attribute('list', [
            'href' => $settings['url_list'],
            'data-height' => $settings['height_list']['size'],
            'data-theme' => $settings['theme_list'],
            'data-lang' => $settings['language'],
            'data-partner' => 'twitter-deck'
        ]);
        ?>
        <a <?php $this->print_render_attribute_string('list'); ?>> </a>
        <?php
    }

    public function get_handle_html($settings) {

        $this->add_render_attribute('handle', 'data-lang', $settings['language']);

        if ($settings['large_button'] === 'yes') {
            $this->add_render_attribute('handle', 'data-size', 'large');
        }

        if ($settings['display_mode_profile'] === 'timeline') {
            $this->add_render_attribute('handle', [
                'href' => 'https://www.twitter.com/' . $settings['username'],
                'class' => 'twitter-' . $settings['display_mode_profile'],
                'data-partner' => 'twitter-deck',
                'data-height' => $settings['height_profile_timeline']['size'],
                'data-theme' => $settings['theme_profile_timeline']
            ]);
        }

        if ($settings['display_mode_profile'] === 'button' && $settings['button_type'] === 'follow-button') {
            $this->add_render_attribute('handle', [
                'class' => 'twitter-' . $settings['button_type'],
                'href' => 'https://www.twitter.com/' . $settings['username']
            ]);

            if ($settings['hide_name'] === 'yes') {
                $this->add_render_attribute('handle', 'data-show-screen-name', 'false');
            }

            if ($settings['show_count'] === '') {
                $this->add_render_attribute('handle', 'data-show-count', 'false');
            }
        }

        if ($settings['display_mode_profile'] === 'button' && $settings['button_type'] === 'mention-button') {
            $this->add_render_attribute('handle', [
                'class' => 'twitter-' . $settings['button_type'],
                'data-text' => $settings['prefill_text'],
                'href' => 'https://www.twitter.com/intent/tweet ?screen_name=' . $settings['screen_name']
            ]);
        }
        ?>
        <a <?php $this->print_render_attribute_string('handle'); ?>> Handle <?php echo $settings['username']; ?></a>
        <?php
    }

    public function get_hashtag_html($settings) {

        $this->add_render_attribute('hashtag', [
            'class' => 'twitter-hashtag-button',
            'href' => 'https://twitter.com/intent/tweet?button_hashtag=' . $settings['hashtag'],
            'data-lang' => $settings['language']
        ]);

        if ($settings['prefill_text_hashtag'] === 'post_title') {
            $this->add_render_attribute('hashtag', 'data-text', $this->current_post_title());
        }

        if ($settings['prefill_text_hashtag'] === 'excerpt') {
            $this->add_render_attribute('hashtag', 'data-text', $this->current_post_excerpt());
        }

        if ($settings['prefill_text_hashtag'] === 'custom') {
            $this->add_render_attribute('hashtag', 'data-text', $settings['prefill_custom']);
        }

        if ($settings['hashtag_large_button'] === 'yes') {
            $this->add_render_attribute('hashtag', 'data-size', 'large');
        }
        $this->add_render_attribute('hashtag', 'data-url', $settings['hashtag_url']);
        ?>
        <a <?php $this->print_render_attribute_string('hashtag'); ?>>Tweet<?php echo $settings['hashtag']; ?> </a>
        <?php
    }

    public function current_post_title() {
        global $post;
        $title = $post->post_title;
        return $title;
    }

    public function current_post_excerpt() {
        global $post;
        if (has_excerpt($post->ID)) {
            return get_the_excerpt($post->ID);
        }
    }

}
