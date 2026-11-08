<?php

namespace EasyElementorAddons\Modules\SocialIcons\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Social Icons Widget
 */
class SocialIcons extends Widget_Base {

    public function get_name() {
        return 'eead-social-icons';
    }

    public function get_title() {
        return esc_html__('Social Icons', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-social-icons';
    }

    public function get_keywords() {
        return ['social', 'icons', 'follow', 'facebook', 'instagram', 'x', 'links', 'eead'];
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

    /** Network => [label, icon, brand color]. */
    // The network icons are not stored in an Icons control, so Elementor does not load these on its own.
    public function get_style_depends() {
        return ['elementor-icons-fa-brands', 'elementor-icons-fa-solid'];
    }

    // Font Awesome 5, which Elementor ships, has no X or Threads icon.
    private function svg_icons() {
        return [
            'x' => '<svg viewBox="0 0 512 512" aria-hidden="true"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>',
            'threads' => '<svg viewBox="0 0 448 512" aria-hidden="true"><path d="M331.5 235.7c2.2.9 4.2 1.9 6.3 2.8 29.2 14.1 50.6 35.2 61.8 61.4 15.7 36.5 17.2 95.8-30.3 143.2-36.2 36.2-80.3 52.5-142.6 53h-.3c-70.2-.5-124.1-24.1-160.4-70.2-32.3-41-48.9-98.1-49.5-169.6V256v-.2C17 184.3 33.6 127.2 65.9 86.2 102.2 40.1 156.2 16.5 226.4 16h.3c70.3.5 124.9 24 162.3 69.9 18.4 22.7 32 50 40.6 81.7l-40.4 10.8c-7.1-25.8-17.8-47.8-32.2-65.4-29.2-35.8-73-54.2-130.5-54.6-57 .5-100.1 18.8-128.2 54.4C72.1 146.1 58.5 194.3 58 256c.5 61.7 14.1 109.9 40.3 143.3 28 35.6 71.2 53.9 128.2 54.4 51.4-.4 85.4-12.6 113.7-40.9 32.3-32.2 31.7-71.8 21.4-95.9-6.1-14.2-17.1-26-31.9-34.9-3.7 26.9-11.8 48.3-24.7 64.8-17.1 21.8-41.4 33.6-72.7 35.3-23.6 1.3-46.3-4.4-63.9-16-20.8-13.8-33-34.8-34.3-59.3-2.5-48.3 35.7-83 95.2-86.4 21.1-1.2 40.9-.3 59.2 2.8-2.4-14.8-7.3-26.6-14.6-35.2-10-11.7-25.6-17.7-46.2-17.8H227c-16.6 0-39 4.6-53.3 26.3l-34.4-23.6c19.2-29.1 50.3-45.1 87.8-45.1h.8c62.6.4 99.9 39.5 103.7 107.7l-.2.2zm-156 68.8c1.3 25.1 28.4 36.8 54.6 35.3 25.6-1.4 54.6-11.4 59.5-73.2-13.2-2.9-27.8-4.4-43.4-4.4-4.8 0-9.6.1-14.4.4-42.9 2.4-57.2 23.2-56.2 41.8l-.1.1z"/></svg>',
        ];
    }

    private function networks() {
        return [
            'facebook' => ['Facebook', 'fab fa-facebook-f', '#1877F2'],
            'instagram' => ['Instagram', 'fab fa-instagram', '#E4405F'],
            'x' => ['X', 'fab fa-x-twitter', '#000000'],
            'linkedin' => ['LinkedIn', 'fab fa-linkedin-in', '#0A66C2'],
            'youtube' => ['YouTube', 'fab fa-youtube', '#FF0000'],
            'tiktok' => ['TikTok', 'fab fa-tiktok', '#010101'],
            'pinterest' => ['Pinterest', 'fab fa-pinterest-p', '#E60023'],
            'threads' => ['Threads', 'fab fa-threads', '#000000'],
            'whatsapp' => ['WhatsApp', 'fab fa-whatsapp', '#25D366'],
            'telegram' => ['Telegram', 'fab fa-telegram-plane', '#26A5E4'],
            'discord' => ['Discord', 'fab fa-discord', '#5865F2'],
            'reddit' => ['Reddit', 'fab fa-reddit-alien', '#FF4500'],
            'snapchat' => ['Snapchat', 'fab fa-snapchat-ghost', '#FFFC00'],
            'github' => ['GitHub', 'fab fa-github', '#181717'],
            'dribbble' => ['Dribbble', 'fab fa-dribbble', '#EA4C89'],
            'behance' => ['Behance', 'fab fa-behance', '#1769FF'],
            'medium' => ['Medium', 'fab fa-medium', '#000000'],
            'spotify' => ['Spotify', 'fab fa-spotify', '#1DB954'],
            'mastodon' => ['Mastodon', 'fab fa-mastodon', '#6364FF'],
            'tripadvisor' => ['Tripadvisor', 'fab fa-tripadvisor', '#34E0A1'],
            'twitch' => ['Twitch', 'fab fa-twitch', '#9146FF'],
            'vimeo' => ['Vimeo', 'fab fa-vimeo-v', '#1AB7EA'],
            'soundcloud' => ['SoundCloud', 'fab fa-soundcloud', '#FF5500'],
            'patreon' => ['Patreon', 'fab fa-patreon', '#FF424D'],
            'yelp' => ['Yelp', 'fab fa-yelp', '#D32323'],
            'google' => ['Google', 'fab fa-google', '#4285F4'],
            'line' => ['LINE', 'fab fa-line', '#06C755'],
            'viber' => ['Viber', 'fab fa-viber', '#7360F2'],
            'vk' => ['VK', 'fab fa-vk', '#0077FF'],
            'xing' => ['XING', 'fab fa-xing', '#006567'],
            'email' => ['Email', 'fas fa-envelope', '#EA4335'],
            'phone' => ['Phone', 'fas fa-phone-alt', '#34A853'],
            'website' => ['Website', 'fas fa-globe', '#5C6070'],
            'rss' => ['RSS', 'fas fa-rss', '#F26522'],
            'custom' => [esc_html__('Custom', 'easy-elementor-addons'), 'fas fa-link', '#5C6070'],
        ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_icons', [
                'label' => esc_html__('Social Icons', 'easy-elementor-addons')
            ]
        );

        $options = [];
        foreach ($this->networks() as $key => $network) {
            $options[$key] = $network[0];
        }

        $repeater = new Repeater();

        $repeater->add_control(
            'network', [
                'label' => esc_html__('Network', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'facebook',
                'options' => $options
            ]
        );

        $repeater->add_control(
            'custom_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-link',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'network' => 'custom'
                ]
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://',
                'description' => esc_html__('For email use mailto:you@example.com, for a phone number tel:+15551234567.', 'easy-elementor-addons'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                ]
            ]
        );

        $repeater->add_control(
            'label', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Uses the network name', 'easy-elementor-addons'),
                'description' => esc_html__('Shown beside the icon or as a tooltip, and read out by screen readers.', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'item_color', [
                'label' => esc_html__('Own Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'description' => esc_html__('Replaces the brand color for this icon.', 'easy-elementor-addons'),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '--eead-si-brand: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'icons', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['network' => 'facebook'],
                    ['network' => 'instagram'],
                    ['network' => 'x'],
                    ['network' => 'linkedin'],
                    ['network' => 'youtube'],
                ],
                'title_field' => '<# var n = { ' . implode(', ', array_map(function ($k, $v) { return "'" . $k . "': '" . esc_js($v) . "'"; }, array_keys($options), $options)) . ' }; #>{{{ label || n[ network ] || network }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'view', [
                'label' => esc_html__('View', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'filled',
                'options' => [
                    'filled' => esc_html__('Filled', 'easy-elementor-addons'),
                    'outline' => esc_html__('Outline', 'easy-elementor-addons'),
                    'soft' => esc_html__('Soft Tint', 'easy-elementor-addons'),
                    'minimal' => esc_html__('Icon Only', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-si-view-'
            ]
        );

        $this->add_control(
            'shape', [
                'label' => esc_html__('Shape', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__('Circle', 'easy-elementor-addons'),
                    'rounded' => esc_html__('Rounded', 'easy-elementor-addons'),
                    'square' => esc_html__('Square', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-si-shape-',
                'condition' => [
                    'view!' => 'minimal'
                ]
            ]
        );

        $this->add_control(
            'colors', [
                'label' => esc_html__('Colors', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'brand',
                'options' => [
                    'brand' => esc_html__('Official Brand Colors', 'easy-elementor-addons'),
                    'custom' => esc_html__('My Own Colors', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-si-colors-'
            ]
        );

        $this->add_control(
            'label_display', [
                'label' => esc_html__('Labels', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Hidden', 'easy-elementor-addons'),
                    'beside' => esc_html__('Beside the Icon', 'easy-elementor-addons'),
                    'tooltip' => esc_html__('Tooltip on Hover', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-si-label-'
            ]
        );

        $this->add_control(
            'hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'lift',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'lift' => esc_html__('Lift', 'easy-elementor-addons'),
                    'grow' => esc_html__('Grow', 'easy-elementor-addons'),
                    'spin' => esc_html__('Spin Icon', 'easy-elementor-addons'),
                    'fill' => esc_html__('Fill With Color', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-si-hover-'
            ]
        );

        $this->add_control(
            'direction', [
                'label' => esc_html__('Direction', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'row',
                'toggle' => false,
                'options' => [
                    'row' => ['title' => esc_html__('Horizontal', 'easy-elementor-addons'), 'icon' => 'eicon-ellipsis-h'],
                    'column' => ['title' => esc_html__('Vertical', 'easy-elementor-addons'), 'icon' => 'eicon-ellipsis-v'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => 'flex-direction: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'flex-end' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => 'justify-content: {{VALUE}}; align-items: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Icons */
        $this->start_controls_section(
            'section_style_icons', [
                'label' => esc_html__('Icons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 8, 'max' => 80]],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-icon: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_size', [
                'label' => esc_html__('Box Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 20, 'max' => 140]],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-box: {{SIZE}}px',
                ],
                'condition' => [
                    'view!' => 'minimal'
                ]
            ]
        );

        $this->add_responsive_control(
            'spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => 'gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'radius', [
                'label' => esc_html__('Corner Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-radius: {{SIZE}}px',
                ],
                'condition' => [
                    'view!' => 'minimal',
                    'shape' => 'rounded'
                ]
            ]
        );

        $this->add_control(
            'border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 1, 'max' => 6]],
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-border: {{SIZE}}px',
                ],
                'condition' => [
                    'view' => 'outline'
                ]
            ]
        );

        $this->start_controls_tabs('icon_tabs', [
            'condition' => [
                'colors' => 'custom'
            ]
        ]);

        $this->start_controls_tab(
            'icon_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
                'condition' => [
                    'colors' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-fg: {{VALUE}}',
                ],
                'condition' => [
                    'colors' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'icon_bg', [
                'label' => esc_html__('Background / Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-bg: {{VALUE}}',
                ],
                'condition' => [
                    'colors' => 'custom',
                    'view!' => 'minimal'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
                'condition' => [
                    'colors' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'icon_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-fg-hover: {{VALUE}}',
                ],
                'condition' => [
                    'colors' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'icon_bg_hover', [
                'label' => esc_html__('Background / Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-bg-hover: {{VALUE}}',
                ],
                'condition' => [
                    'colors' => 'custom',
                    'view!' => 'minimal'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* Style: Labels */
        $this->start_controls_section(
            'section_style_labels', [
                'label' => esc_html__('Labels', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'label_display!' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .eead-si-text'
            ]
        );

        $this->add_control(
            'label_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'description' => esc_html__('Leave empty to match the icon.', 'easy-elementor-addons'),
                'selectors' => [
                    '{{WRAPPER}} .eead-si-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label_display' => 'beside'
                ]
            ]
        );

        $this->add_responsive_control(
            'label_padding', [
                'label' => esc_html__('Button Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-si-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'label_display' => 'beside',
                    'view!' => 'minimal'
                ]
            ]
        );

        $this->add_control(
            'tooltip_bg', [
                'label' => esc_html__('Tooltip Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-tip-bg: {{VALUE}}',
                ],
                'condition' => [
                    'label_display' => 'tooltip'
                ]
            ]
        );

        $this->add_control(
            'tooltip_color', [
                'label' => esc_html__('Tooltip Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-si' => '--eead-si-tip-fg: {{VALUE}}',
                ],
                'condition' => [
                    'label_display' => 'tooltip'
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $networks = $this->networks();

        if (empty($settings['icons'])) {
            return;
        }
        ?>
        <ul class="eead-si">
            <?php
            foreach ($settings['icons'] as $index => $item) {
                $key = isset($networks[$item['network']]) ? $item['network'] : 'custom';
                $network = $networks[$key];
                $label = '' !== trim((string) $item['label']) ? $item['label'] : $network[0];
                $icon = 'custom' === $key && !empty($item['custom_icon']['value']) ? $item['custom_icon'] : ['value' => $network[1], 'library' => 0 === strpos($network[1], 'fab') ? 'fa-brands' : 'fa-solid'];
                $link_key = 'link-' . $index;

                $this->add_render_attribute($link_key, [
                    'class' => ['eead-si-item', 'eead-si-' . $key, 'elementor-repeater-item-' . $item['_id']],
                    'style' => '--eead-si-brand-default: ' . $network[2],
                    'aria-label' => $label,
                ]);
                if (!empty($item['link']['url'])) {
                    $this->add_link_attributes($link_key, $item['link']);
                }
                $tag = !empty($item['link']['url']) ? 'a' : 'span';
                ?>
                <li>
                    <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string($link_key); ?>>
                        <span class="eead-si-icon"><?php
                        $svg = $this->svg_icons();
                        if ('custom' !== $key && isset($svg[$key])) {
                            echo $svg[$key]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed markup above.
                        } else {
                            Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
                        }
                        ?></span>
                        <span class="eead-si-text" aria-hidden="true"><?php echo esc_html($label); ?></span>
                    </<?php echo esc_attr($tag); ?>>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }

}
