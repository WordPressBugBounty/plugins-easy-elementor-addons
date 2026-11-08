<?php

namespace EasyElementorAddons\Modules\Accordion\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Accordion Widget
 */
class Accordion extends Widget_Base {

    public function get_name() {
        return 'eead-accordion';
    }

    public function get_title() {
        return esc_html__('Accordion', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-accordion';
    }

    public function get_keywords() {
        return ['accordion', 'faq', 'toggle', 'collapse', 'eead'];
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
            'content_settings', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Accordion', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'wisiwyg',
                'options' => [
                    'elementor_template' => esc_html__('Elementor Template', 'easy-elementor-addons'),
                    'wisiwyg' => esc_html__('WISIWYG', 'easy-elementor-addons'),
                ]
            ]
        );

        $repeater->add_control(
            'elementor_template', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => eead_get_elementor_templates(),
                'label_block' => 'true',
                'condition' => ['content_type' => 'elementor_template']
            ]
        );

        $repeater->add_control(
            'wisiwyg_content', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at. Ei eum eleifend laboramus, nonumy legere quaerendum vis cu. Ut facete quodsi eloquentiam mel. Pri purto sale option at.',
                'placeholder' => esc_html__('Type your description here', 'easy-elementor-addons'),
                'condition' => ['content_type' => 'wisiwyg']
            ]
        );

        $repeater->add_control(
            'keep_open', [
                'label' => esc_html__('Show Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $repeater->add_control(
            'item_id', [
                'label' => esc_html__('Item ID', 'easy-elementor-addons'),
                'description' => esc_html__('Optional. Links to #your-id open this item and scroll to it. Letters, numbers, dashes and underscores only.', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'ai' => ['active' => false],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'items', [
                'label' => esc_html__('Items', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Accordion #1', 'easy-elementor-addons'),
                        'wisiwyg_content' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at. Ei eum eleifend laboramus, nonumy legere quaerendum vis cu. Ut facete quodsi eloquentiam mel. Pri purto sale option at.'
                    ],
                    [
                        'title' => esc_html__('Accordion #2', 'easy-elementor-addons'),
                        'wisiwyg_content' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at. Ei eum eleifend laboramus, nonumy legere quaerendum vis cu. Ut facete quodsi eloquentiam mel. Pri purto sale option at.'
                    ],
                    [
                        'title' => esc_html__('Accordion #3', 'easy-elementor-addons'),
                        'wisiwyg_content' => 'Cu utamur torquatos his. Qui dicta propriae signiferumque ex, esse eligendi adipisci te mel. At ius dolores offendit, vis case zril causae an. Vel integre euripidis expetendis eu. Omnis eleifend intellegebat vel cu, pri dicant admodum at. Ei eum eleifend laboramus, nonumy legere quaerendum vis cu. Ut facete quodsi eloquentiam mel. Pri purto sale option at.'
                    ]
                ],
                'title_field' => '{{ title }}'
            ]
        );

        $this->add_control(
            'one_at_a_time', [
                'label' => esc_html__('Open One Item at a Time', 'easy-elementor-addons'),
                'description' => esc_html__('Opening an item closes the others.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h3'
            ]
        );

        $this->add_control(
            'faq_schema', [
                'label' => esc_html__('FAQ Schema', 'easy-elementor-addons'),
                'description' => esc_html__('Adds FAQPage structured data so search engines can show these items as FAQs. Only text items are included, not Elementor templates.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'other_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'accordion_open_icon', [
                'label' => esc_html__('Open Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'mdi-chevron-down',
                    'library' => 'mdi',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'accordion_close_icon', [
                'label' => esc_html__('Close Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'mdi-chevron-up',
                    'library' => 'mdi',
                ],
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'accordion_open_icon[value]!' => '',
                ]
            ]
        );

        $this->add_control(
            'icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-accordion-icon-'
            ]
        );

        $this->add_control(
            'hr1', [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $this->add_responsive_control(
            'content_height', [
                'label' => esc_html__('Fixed Content Height', 'easy-elementor-addons'),
                'description' => esc_html__('Content will show with scrollbar. Leave empty for full height.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-content-height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'accordion_section_style', [
                'label' => esc_html__('Accordion', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'accordion_bg_color', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-background: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'accordion_boxshadow',
                'selector' => '{{WRAPPER}} .eead-each-accordion'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'accordion_border',
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
                'selector' => '{{WRAPPER}} .eead-each-accordion'
            ]
        );

        $this->add_responsive_control(
            'accordion_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'accordion_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'accordion_gap', [
                'label' => esc_html__('Gap Between Accordion', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header_section_style', [
                'label' => esc_html__('Header', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-accordion-title .eead-accordion-title-text'
            ]
        );

        $this->add_responsive_control(
            'header_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-header-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-header-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'open_close_icon_header',
            [
                'label' => esc_html__('Open/Close Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-icon-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'icon_box_size', [
                'label' => esc_html__('Icon Box Size', 'easy-elementor-addons'),
                'description' => esc_html__('A fixed square for the icon, centred inside it - keeps the background round or square whatever the icon.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-accordion-container .eead-each-accordion .eead-accordion-icon' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; display: grid; place-items: center; line-height: 0;',
                    // Only the spacing: the open and close icons are shown and hidden by display.
                    '{{WRAPPER}} .eead-accordion-container .eead-each-accordion .eead-accordion-icon > div' => 'line-height: 0;',
                ]
            ]
        );

        $this->add_control(
            'icon_padding', [
                'label' => esc_html__('Icon Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-icon-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_radius', [
                'label' => esc_html__('Icon Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-icon-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'title_tabs'
        );

        $this->start_controls_tab(
            'title_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-header-background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-title-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'icon_bg_color', [
                'label' => esc_html__('Icon Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-icon-bg-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-icon-color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_active_tab', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_bg_color_active', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-header-background-active: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_color_active', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-title-color-active: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'icon_bg_color_active', [
                'label' => esc_html__('Icon Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-active-icon-bg-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'icon_color_active', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-active-icon-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-accordion-content'
            ]
        );

        $this->add_control(
            'content_bg_color', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-content-bg-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'content_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-content-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'content_link_color', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-accordion-content a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'content_link_hover_color', [
                'label' => esc_html__('Link Hover Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-accordion-content a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-content-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-accordion-content-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $accordions = $settings['items'];
        $title_tag = eead_check_allowed_html_tags($settings['title_tag'], 'h3');
        $has_icon = !empty($settings['accordion_open_icon']['value']);
        $one_at_a_time = $settings['one_at_a_time'] === 'yes';
        $opened = false;
        $faq = [];
        ?>
        <div class="eead-accordion-container" data-one-at-a-time="<?php echo esc_attr($one_at_a_time ? 'yes' : 'no'); ?>">
            <?php
            foreach ($accordions as $key => $accordion) {
                // With one item at a time, only the first "Show Content" item starts open.
                $is_open = $accordion['keep_open'] == 'yes' && !($one_at_a_time && $opened);
                $opened = $opened || $is_open;
                $uid = $this->get_id() . '-' . $key;
                $item_id = !empty($accordion['item_id']) ? sanitize_html_class($accordion['item_id']) : '';
                ?>
                <div class="eead-each-accordion eead-each-accordion-<?php echo esc_attr($key) . ($is_open ? ' eead-open' : ''); ?>"<?php echo $item_id ? ' id="' . esc_attr($item_id) . '"' : ''; ?>>
                    <div class="eead-accordion-title" id="eead-accordion-title-<?php echo esc_attr($uid); ?>" role="button" tabindex="0" aria-expanded="<?php echo esc_attr($is_open ? 'true' : 'false'); ?>" aria-controls="eead-accordion-content-<?php echo esc_attr($uid); ?>">
                        <<?php echo esc_attr($title_tag); ?> class="eead-accordion-title-text"><?php echo esc_html($accordion['title']); ?></<?php echo esc_attr($title_tag); ?>>
                        <?php if ($has_icon) { ?>
                            <div class="eead-accordion-icon">
                                <div class="eead-accordion-open-icon">
                                    <?php Icons_Manager::render_icon($settings['accordion_open_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <div class="eead-accordion-close-icon">
                                    <?php
                                    // An emptied close icon keeps the open one, instead of no icon at all.
                                    Icons_Manager::render_icon(!empty($settings['accordion_close_icon']['value']) ? $settings['accordion_close_icon'] : $settings['accordion_open_icon'], ['aria-hidden' => 'true']);
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="eead-accordion-content" id="eead-accordion-content-<?php echo esc_attr($uid); ?>" role="region" aria-labelledby="eead-accordion-title-<?php echo esc_attr($uid); ?>" <?php echo ($is_open ? 'style="display:block"' : ''); ?>>
                        <div class="eead-accordion-content-scroll">
                            <?php
                            if ($accordion['content_type'] == 'wisiwyg') {
                                $content = eead_parse_wysiwyg_content($accordion['wisiwyg_content']);
                                echo wp_kses_post($content);

                                if ($settings['faq_schema'] === 'yes' && trim($accordion['title']) !== '' && trim(wp_strip_all_tags($content)) !== '') {
                                    $faq[] = [
                                        '@type' => 'Question',
                                        'name' => wp_strip_all_tags($accordion['title']),
                                        'acceptedAnswer' => [
                                            '@type' => 'Answer',
                                            'text' => wp_kses($content, ['a' => ['href' => []], 'br' => [], 'p' => [], 'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'ul' => [], 'ol' => [], 'li' => [], 'h2' => [], 'h3' => [], 'h4' => [], 'h5' => [], 'h6' => []]),
                                        ],
                                    ];
                                }
                            } else if ($accordion['content_type'] == 'elementor_template' && 'publish' === get_post_status((int) $accordion['elementor_template'])) {
                                echo Plugin::instance()->frontend->get_builder_content_for_display($accordion['elementor_template']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor-rendered content.
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        if ($faq) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq,
            ];
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON-encoded with tags hex-escaped.
        }
    }

}
