<?php

namespace EasyElementorAddons\Modules\WhatsappChat\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * WhatsApp Chat Widget
 */
class WhatsappChat extends Widget_Base {

    public function get_name() {
        return 'eead-whatsapp-chat';
    }

    public function get_title() {
        return esc_html__('WhatsApp Chat', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-whatsapp-chat';
    }

    public function get_keywords() {
        return ['whatsapp', 'chat', 'support', 'contact', 'floating button', 'messenger', 'eead'];
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
            'section_agents', [
                'label' => esc_html__('Agents', 'easy-elementor-addons')
            ]
        );

        $agent = new Repeater();

        $agent->add_control(
            'name', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Sales Team', 'easy-elementor-addons')
            ]
        );

        $agent->add_control(
            'role', [
                'label' => esc_html__('Role', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Questions about plans and pricing', 'easy-elementor-addons')
            ]
        );

        $agent->add_control(
            'phone', [
                'label' => esc_html__('WhatsApp Number', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '+1 555 123 4567',
                'description' => esc_html__('Include the country code. Spaces, dashes and the + sign are removed.', 'easy-elementor-addons'),
                'default' => '15551234567'
            ]
        );

        $agent->add_control(
            'message', [
                'label' => esc_html__('Pre-filled Message', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => esc_html__('Hi! I have a question.', 'easy-elementor-addons'),
                'description' => esc_html__('Typed into the visitor\'s chat, ready to send.', 'easy-elementor-addons')
            ]
        );

        $agent->add_control(
            'avatar', [
                'label' => esc_html__('Photo', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA
            ]
        );

        $agent->add_control(
            'available', [
                'label' => esc_html__('Show as Available', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Adds a green dot to the photo.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'agents', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $agent->get_controls(),
                'default' => [
                    [
                        'name' => esc_html__('Sales Team', 'easy-elementor-addons'),
                        'role' => esc_html__('Questions about plans and pricing', 'easy-elementor-addons'),
                        'phone' => '15551234567',
                    ],
                ],
                'title_field' => '{{{ name }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'display', [
                'label' => esc_html__('Display', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'floating',
                'options' => [
                    'floating' => esc_html__('Floating in a Corner', 'easy-elementor-addons'),
                    'inline' => esc_html__('In the Page', 'easy-elementor-addons'),
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'position', [
                'label' => esc_html__('Corner', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'right',
                'options' => [
                    'left' => ['title' => esc_html__('Bottom Left', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-left'],
                    'right' => ['title' => esc_html__('Bottom Right', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-right'],
                ],
                'condition' => [
                    'display' => 'floating'
                ]
            ]
        );

        $this->add_responsive_control(
            'offset_x', [
                'label' => esc_html__('Distance From Side', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 200]],
                'default' => ['size' => 24],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-floating' => '--eead-wa-x: {{SIZE}}px',
                ],
                'condition' => [
                    'display' => 'floating'
                ]
            ]
        );

        $this->add_responsive_control(
            'offset_y', [
                'label' => esc_html__('Distance From Bottom', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 300]],
                'default' => ['size' => 24],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-floating' => '--eead-wa-y: {{SIZE}}px',
                ],
                'condition' => [
                    'display' => 'floating'
                ]
            ]
        );

        $this->add_responsive_control(
            'inline_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'flex-end' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-inline' => 'align-items: {{VALUE}}',
                ],
                'condition' => [
                    'display' => 'inline'
                ]
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Chat with us', 'easy-elementor-addons'),
                'description' => esc_html__('Leave empty for a round icon button.', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-whatsapp',
                    'library' => 'fa-brands',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'pulse', [
                'label' => esc_html__('Pulse Ring', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'prefix_class' => 'eead-wa-pulse-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box', [
                'label' => esc_html__('Chat Box', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'open_mode', [
                'label' => esc_html__('When Clicked', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'box',
                'options' => [
                    'box' => esc_html__('Open the Chat Box', 'easy-elementor-addons'),
                    'direct' => esc_html__('Go Straight to WhatsApp', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('Going straight to WhatsApp uses the first agent.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'box_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Need help?', 'easy-elementor-addons'),
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->add_control(
            'box_subtitle', [
                'label' => esc_html__('Subtitle', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('We usually reply within a few minutes.', 'easy-elementor-addons'),
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->add_control(
            'greeting', [
                'label' => esc_html__('Greeting', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__('Hi there 👋 How can we help you today?', 'easy-elementor-addons'),
                'description' => esc_html__('Shown as a chat bubble at the top of the box.', 'easy-elementor-addons'),
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->add_control(
            'start_text', [
                'label' => esc_html__('Start Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Start chat', 'easy-elementor-addons'),
                'description' => esc_html__('Used when there is one agent. With several agents, visitors pick one from the list.', 'easy-elementor-addons'),
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->add_control(
            'auto_open', [
                'label' => esc_html__('Open Automatically After (seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 120,
                'default' => 0,
                'description' => esc_html__('0 keeps it closed. Once a visitor closes the box it stays closed for the rest of their visit.', 'easy-elementor-addons'),
                'render_type' => 'template',
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Button */
        $this->start_controls_section(
            'section_style_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-wa-button',
                'condition' => [
                    'button_text!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'button_size', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 36, 'max' => 90]],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-button' => '--eead-wa-size: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 12, 'max' => 50]],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-button-icon' => 'font-size: {{SIZE}}px',
                ]
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa' => '--eead-wa-green: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa' => '--eead-wa-on-green: {{VALUE}}',
                    '{{WRAPPER}} .eead-wa-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-wa-button svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_bg_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-button:hover, {{WRAPPER}} .eead-wa-button:focus-visible' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-button:hover, {{WRAPPER}} .eead-wa-button:focus-visible' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .eead-wa-button'
            ]
        );

        $this->end_controls_section();

        /* Style: Chat Box */
        $this->start_controls_section(
            'section_style_box', [
                'label' => esc_html__('Chat Box', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'open_mode' => 'box'
                ]
            ]
        );

        $this->add_responsive_control(
            'box_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 240, 'max' => 480]],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-panel' => 'width: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control(
            'header_bg', [
                'label' => esc_html__('Header Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-header' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_color', [
                'label' => esc_html__('Header Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-header, {{WRAPPER}} .eead-wa-close' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'body_bg', [
                'label' => esc_html__('Body Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-body' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'bubble_bg', [
                'label' => esc_html__('Greeting Bubble', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-bubble' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'bubble_color', [
                'label' => esc_html__('Greeting Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-bubble' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'agent_bg', [
                'label' => esc_html__('Agent Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-agent' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'agent_bg_hover', [
                'label' => esc_html__('Agent Hover Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-agent:hover, {{WRAPPER}} .eead-wa-agent:focus-visible' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 30]],
                'selectors' => [
                    '{{WRAPPER}} .eead-wa-panel' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .eead-wa-panel'
            ]
        );

        $this->end_controls_section();
    }

    /** wa.me link for an agent, with the pre-filled message. */
    private function chat_url($agent) {
        $number = preg_replace('/\D+/', '', (string) $agent['phone']);
        $url = 'https://wa.me/' . $number;
        if ('' !== trim((string) $agent['message'])) {
            $url .= '?text=' . rawurlencode($agent['message']);
        }
        return $url;
    }

    private function render_avatar($agent) {
        $classes = 'eead-wa-avatar' . ('yes' === $agent['available'] ? ' eead-wa-online' : '');
        echo '<span class="' . esc_attr($classes) . '">';
        if (!empty($agent['avatar']['url'])) {
            echo '<img src="' . esc_url($agent['avatar']['url']) . '" alt="" loading="lazy" decoding="async">';
        } else {
            $initials = '';
            foreach (array_slice(preg_split('/\s+/', trim((string) $agent['name'])), 0, 2) as $word) {
                $initials .= mb_substr($word, 0, 1);
            }
            echo '<span class="eead-wa-initials">' . esc_html(mb_strtoupper($initials)) . '</span>';
        }
        echo '</span>';
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $agents = array_values(array_filter((array) $settings['agents'], function ($agent) {
            return '' !== preg_replace('/\D+/', '', (string) $agent['phone']);
        }));

        if (empty($agents)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="eead-wa-empty">' . esc_html__('Add a WhatsApp number to an agent to show the chat button.', 'easy-elementor-addons') . '</div>';
            }
            return;
        }

        $floating = 'inline' !== $settings['display'];
        $direct = 'direct' === $settings['open_mode'];
        $panel_id = 'eead-wa-panel-' . $this->get_id();
        $has_text = '' !== trim((string) $settings['button_text']);

        $this->add_render_attribute('wrap', [
            'class' => ['eead-wa', $floating ? 'eead-wa-floating' : 'eead-wa-inline', $floating ? 'eead-wa-' . ('left' === $settings['position'] ? 'left' : 'right') : ''],
            'data-settings' => wp_json_encode([
                'autoOpen' => $direct ? 0 : max(0, (int) $settings['auto_open']),
                'id' => $this->get_id(),
            ]),
        ]);

        $button_inner = '<span class="eead-wa-button-icon">';
        ob_start();
        Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
        $button_inner .= ob_get_clean() . '</span>';
        if ($has_text) {
            $button_inner .= '<span class="eead-wa-button-text">' . esc_html($settings['button_text']) . '</span>';
        }
        $button_class = 'eead-wa-button' . ($has_text ? '' : ' eead-wa-button-round');
        $button_label = $has_text ? '' : ' aria-label="' . esc_attr__('Chat on WhatsApp', 'easy-elementor-addons') . '"';
        ?>
        <div <?php $this->print_render_attribute_string('wrap'); ?>>
            <?php if ($direct) { ?>
                <a class="<?php echo esc_attr($button_class); ?>" href="<?php echo esc_url($this->chat_url($agents[0])); ?>" target="_blank" rel="noopener"<?php echo $button_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $button_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
            <?php } else { ?>
                <div class="eead-wa-panel" id="<?php echo esc_attr($panel_id); ?>" role="dialog" aria-label="<?php echo esc_attr($settings['box_title'] ?: __('WhatsApp chat', 'easy-elementor-addons')); ?>" hidden>
                    <div class="eead-wa-header">
                        <?php if (1 === count($agents)) {
                            $this->render_avatar($agents[0]);
                        } else { ?>
                            <span class="eead-wa-header-icon"><?php Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?></span>
                        <?php } ?>
                        <span class="eead-wa-header-text">
                            <?php if ('' !== $settings['box_title']) { ?>
                                <span class="eead-wa-title"><?php echo esc_html($settings['box_title']); ?></span>
                            <?php } ?>
                            <?php if ('' !== $settings['box_subtitle']) { ?>
                                <span class="eead-wa-subtitle"><?php echo esc_html($settings['box_subtitle']); ?></span>
                            <?php } ?>
                        </span>
                        <button type="button" class="eead-wa-close" aria-label="<?php esc_attr_e('Close', 'easy-elementor-addons'); ?>"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="eead-wa-body">
                        <?php if ('' !== trim((string) $settings['greeting'])) { ?>
                            <div class="eead-wa-bubble"><?php echo nl2br(esc_html($settings['greeting'])); ?></div>
                        <?php } ?>
                        <?php if (1 === count($agents)) { ?>
                            <a class="eead-wa-start" href="<?php echo esc_url($this->chat_url($agents[0])); ?>" target="_blank" rel="noopener">
                                <span class="eead-wa-start-icon"><?php Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?></span>
                                <?php echo esc_html($settings['start_text'] ?: __('Start chat', 'easy-elementor-addons')); ?>
                            </a>
                        <?php } else { ?>
                            <div class="eead-wa-agents">
                                <?php foreach ($agents as $agent) { ?>
                                    <a class="eead-wa-agent" href="<?php echo esc_url($this->chat_url($agent)); ?>" target="_blank" rel="noopener">
                                        <?php $this->render_avatar($agent); ?>
                                        <span class="eead-wa-agent-text">
                                            <span class="eead-wa-agent-name"><?php echo esc_html($agent['name']); ?></span>
                                            <?php if ('' !== $agent['role']) { ?>
                                                <span class="eead-wa-agent-role"><?php echo esc_html($agent['role']); ?></span>
                                            <?php } ?>
                                        </span>
                                        <span class="eead-wa-agent-go"><?php Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <button type="button" class="<?php echo esc_attr($button_class); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr($panel_id); ?>"<?php echo $button_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $button_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
            <?php } ?>
        </div>
        <?php
    }

}
