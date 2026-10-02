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

    public function get_keywords() {
        return ['social share', 'share', 'social', 'eead'];
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
                'label' => esc_html__('Pinterest', 'easy-elementor-addons'),
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
            'reddit', [
                'label' => esc_html__('Reddit', 'easy-elementor-addons'),
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
        $show_text = $settings['show_text'];
        $show_icon = $settings['show_icon'];

        $title = rawurlencode(html_entity_decode(wp_strip_all_tags(get_the_title()), ENT_QUOTES, 'UTF-8'));
        $url = rawurlencode(get_the_permalink());
        $hover_animation = $settings['hover_animation'];

        $networks = [
            'facebook' => ['class' => 'facebook', 'icon' => 'icofont-facebook', 'label' => esc_html__('Facebook', 'easy-elementor-addons'), 'href' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url . '&t=' . $title],
            'twitter' => ['class' => 'twitter', 'icon' => 'icofont-x-twitter', 'label' => esc_html__('Twitter', 'easy-elementor-addons'), 'href' => 'https://x.com/intent/tweet?text=' . $title . '&url=' . $url],
            'pintrest' => ['class' => 'pinterest', 'icon' => 'icofont-pinterest', 'label' => esc_html__('Pinterest', 'easy-elementor-addons'), 'href' => 'https://pinterest.com/pin/create/button/?url=' . $url],
            'linkedin' => ['class' => 'linkedin', 'icon' => 'icofont-linkedin', 'label' => esc_html__('Linkedin', 'easy-elementor-addons'), 'href' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title],
            'vkontakte' => ['class' => 'vkontakte', 'icon' => 'icofont-vk', 'label' => esc_html__('Vkontakte', 'easy-elementor-addons'), 'href' => 'https://vk.com/share.php?url=' . $url . '&title=' . $title],
            'tumblr' => ['class' => 'tumblr', 'icon' => 'icofont-tumblr', 'label' => esc_html__('Tumblr', 'easy-elementor-addons'), 'href' => 'https://www.tumblr.com/share/link?url=' . $url . '&name=' . $title],
            'blogger' => ['class' => 'blogger', 'icon' => 'icofont-blogger', 'label' => esc_html__('Blogger', 'easy-elementor-addons'), 'href' => 'https://www.blogger.com/blog-this.g?u=' . $url . '&n=' . $title],
            'reddit' => ['class' => 'reddit', 'icon' => 'icofont-reddit', 'label' => esc_html__('Reddit', 'easy-elementor-addons'), 'href' => 'https://reddit.com/submit?url=' . $url . '&title=' . $title],
            'wordpress' => ['class' => 'wordpress', 'icon' => 'icofont-brand-wordpress', 'label' => esc_html__('WordPress', 'easy-elementor-addons'), 'href' => 'https://wordpress.com/press-this.php?u=' . $url . '&t=' . $title],
            'telegram' => ['class' => 'telegram', 'icon' => 'icofont-telegram', 'label' => esc_html__('Telegram', 'easy-elementor-addons'), 'href' => 'https://t.me/share/url?url=' . $url . '&text=' . $title],
            'whatsapp' => ['class' => 'whatsapp', 'icon' => 'icofont-whatsapp', 'label' => esc_html__('Whatsapp', 'easy-elementor-addons'), 'href' => 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url],
            'line' => ['class' => 'line', 'icon' => 'icofont-line', 'label' => esc_html__('Line', 'easy-elementor-addons'), 'href' => 'https://lineit.line.me/share/ui?url=' . $url . '&text=' . $title],
            'email' => ['class' => 'email', 'icon' => 'icofont-envelope', 'label' => esc_html__('Email', 'easy-elementor-addons'), 'href' => 'mailto:?subject=' . $title . '&body=' . $url]
        ];

        echo '<div class="eead-social-share-container">';

        foreach ($networks as $key => $network) {
            if (!isset($settings[$key]) || $settings[$key] !== 'yes') {
                continue;
            }

            echo '<a target="_blank" rel="noopener noreferrer" class="eead-social-share-link eead-' . esc_attr($network['class']) . ' elementor-animation-' . esc_attr($hover_animation) . '" href="' . esc_url($network['href']) . '">';
            echo $show_icon == 'yes' ? '<i class="eead-icon ' . esc_attr($network['icon']) . '"></i>' : '';
            echo $show_text == 'yes' ? '<span class="eead-social-share-text">' . esc_html($network['label']) . '</span>' : '';
            echo '</a>';
        }
        echo '</div>';
    }

}
