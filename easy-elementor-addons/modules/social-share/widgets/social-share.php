<?php

namespace EasyElementorAddons\Modules\SocialShare\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class SocialShare extends Widget_Base {

    public function get_name() {
        return 'eead-social-share';
    }

    public function get_title() {
        return esc_html__('Social Share', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-social-share';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Social Share', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'facebook', [
                'label' => esc_html__('Facebook', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'twitter', [
                'label' => esc_html__('Twitter', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'pintrest', [
                'label' => esc_html__('Pintrest', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'linkedin', [
                'label' => esc_html__('Linkedin', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'vkontakte', [
                'label' => esc_html__('VKontakte', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'tumblr', [
                'label' => esc_html__('Tumblr', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'blogger', [
                'label' => esc_html__('Blogger', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'digg', [
                'label' => esc_html__('Digg', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'reddit', [
                'label' => esc_html__('Reddit', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'delicious', [
                'label' => esc_html__('Delicious', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'wordpress', [
                'label' => esc_html__('WordPress', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'skype', [
                'label' => esc_html__('Skype', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'telegram', [
                'label' => esc_html__('Telegram', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'whatsapp', [
                'label' => esc_html__('Whatsapp', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'line', [
                'label' => esc_html__('Line', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'email', [
                'label' => esc_html__('Email', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'column_numbers', [
                'label' => esc_html__('Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 18,
                        'step' => 1,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 4,
                ],
                'tablet_default' => [
                    'size' => 2,
                ],
                'mobile_default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container' => 'grid-template-columns: repeat({{column_numbers.SIZE}}, 1fr);',
                ]
            ]
        );

        $this->add_control(
            'button_column_gap', [
                'label' => esc_html__('Columns Space', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container' => 'grid-column-gap: {{button_column_gap.SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'button_row_gap', [
                'label' => esc_html__('Row Space', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container' => 'grid-row-gap: {{button_row_gap.SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'show_text', [
                'label' => esc_html__('Show Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_icon', [
                'label' => esc_html__('Show Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'icon_alignment', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons'),
                    'top' => esc_html__('Top', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'selectors_dictionary' => [
                    'left' => 'flex-direction: row;',
                    'right' => 'flex-direction: row-reverse;',
                    'top' => 'flex-direction: column;',
                    'bottom' => 'flex-direction: column-reverse;',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a' => '{{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40,
                        'step' => 1,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-social-share-container a'
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-social-share-container a'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
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
                'selector' => '{{WRAPPER}} .eead-social-share-container a'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .eead-social-share-container a'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-social-share-container a:hover'
            ]
        );

        $this->add_control(
            'button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-social-share-container a:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .eead-social-share-container a:hover'
            ]
        );

        $this->add_control(
            'hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $facebook = esc_html($settings['facebook']);
        $twitter = esc_html($settings['twitter']);
        $pintrest = esc_html($settings['pintrest']);
        $linkedin = esc_html($settings['linkedin']);
        $vkontakte = esc_html($settings['vkontakte']);
        $tumblr = esc_html($settings['tumblr']);
        $blogger = esc_html($settings['blogger']);
        $digg = esc_html($settings['digg']);
        $reddit = esc_html($settings['reddit']);
        $delicious = esc_html($settings['delicious']);
        $wordpress = esc_html($settings['wordpress']);
        $skype = esc_html($settings['skype']);
        $telegram = esc_html($settings['telegram']);
        $whatsapp = esc_html($settings['whatsapp']);
        $line = esc_html($settings['line']);
        $email = esc_html($settings['email']);
        $show_text = $settings['show_text'];
        $show_icon = $settings['show_icon'];

        $title = get_the_title();
        $url = get_the_permalink();
        $hover_animation = $settings['hover_animation'];

        echo '<div class="eead-social-share-container">';

        if ($facebook == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-facebook elementor-animation-' . esc_attr($hover_animation) . '" href="http://www.facebook.com/sharer/sharer.php?u=' . esc_url($url) . '&amp;t=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-facebook"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Facebook', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($twitter == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-twitter elementor-animation-' . esc_attr($hover_animation) . '" href="https://twitter.com/intent/tweet?text=' . esc_html($title) . '&url=' . esc_url($url) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-x-twitter"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Twitter', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($pintrest == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-pinterest elementor-animation-' . esc_attr($hover_animation) . '" href="http://pinterest.com/pin/create/button/?url=' . esc_url($url) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-pinterest"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Pintrest', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($linkedin == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-linkedin elementor-animation-' . esc_attr($hover_animation) . '" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . esc_url($url) . '&title=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-linkedin"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Linkedin', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($vkontakte == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-vkontakte elementor-animation-' . esc_attr($hover_animation) . '" href="http://vk.com/share.php?url=' . esc_url($url) . '&title=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-vk"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Vkontakte', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($tumblr == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-tumblr elementor-animation-' . esc_attr($hover_animation) . '" href="https://www.tumblr.com/share/link?url=' . esc_url($url) . '&name=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-tumblr"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Tumblr', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($blogger == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-blogger elementor-animation-' . esc_attr($hover_animation) . '" href="https://www.blogger.com/blog-this.g?u=' . esc_url($url) . '&n=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-blogger"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Blogger', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($digg == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-digg elementor-animation-' . esc_attr($hover_animation) . '" href="http://digg.com/submit?url=' . esc_url($url) . '&title=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-digg"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Digg', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($reddit == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-reddit elementor-animation-' . esc_attr($hover_animation) . '" href="https://reddit.com/submit?url=' . esc_url($url) . '&title=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-reddit"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Reddit', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($delicious == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-evernote elementor-animation-' . esc_attr($hover_animation) . '" href="https://www.evernote.com/clip.action?url=' . esc_url($url) . '&title=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-evernote"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Evernote', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($wordpress == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-wordpress elementor-animation-' . esc_attr($hover_animation) . '" href="https://wordpress.com/press-this.php?u=' . esc_url($url) . '&t=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-brand-wordpress"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('WordPress', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($skype == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-skype elementor-animation-' . esc_attr($hover_animation) . '" href="https://web.skype.com/share?url=' . esc_url($url) . '&text=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-skype"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Skype', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($telegram == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-telegram elementor-animation-' . esc_attr($hover_animation) . '" href="https://t.me/share/url?url=' . esc_url($url) . '&text=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-telegram"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Telegram', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($whatsapp == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-whatsapp elementor-animation-' . esc_attr($hover_animation) . '" href="https://api.whatsapp.com/send?phone=&text=' . esc_html($title) . " " . esc_url($url) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-whatsapp"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Whatsapp', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($line == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-line elementor-animation-' . esc_attr($hover_animation) . '" href="https://lineit.line.me/share/ui?url=' . esc_url($url) . '&text=' . esc_html($title) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-line"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Line', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        if ($email == 'yes') {
            echo '<a target="_blank" class="eead-social-share-link eead-email elementor-animation-' . esc_attr($hover_animation) . '" href="mailto:?Subject=' . esc_html($title) . '&Body=' . esc_url($url) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon icofont-envelope"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html__('Email', 'easy-elementor-addons') . '</span>' : '';
            echo '</a>';
        }
        echo '</div>';
    }

}
