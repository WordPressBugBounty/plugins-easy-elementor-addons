<?php

namespace EasyElementorAddons\Modules\ScrollTextReveal\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Text Scroll Reveal Widget
 */
class ScrollTextReveal extends Widget_Base {

    public function get_name() {
        return 'eead-scroll-text-reveal';
    }

    public function get_title() {
        return esc_html__('Text Scroll Reveal', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-scroll-text-reveal';
    }

    public function get_keywords() {
        return ['text reveal', 'scroll animation', 'text animation', 'scroll text', 'reveal', 'heading', 'eead'];
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
                'label' => esc_html__('Text', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'dynamic' => ['active' => true],
                'default' => esc_html__('We build tools that feel <em>effortless</em>, so your team can focus on the work that matters.', 'easy-elementor-addons'),
                'description' => esc_html__('Wrap words in <em>, <strong> or <mark> to give them the highlight color.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'html_tag', [
                'label' => esc_html__('HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h2'
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'effect', [
                'label' => esc_html__('Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'color',
                'options' => [
                    'color' => esc_html__('Color Fill', 'easy-elementor-addons'),
                    'opacity' => esc_html__('Fade In', 'easy-elementor-addons'),
                    'blur' => esc_html__('Blur In', 'easy-elementor-addons'),
                    'rise' => esc_html__('Rise Up', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-str-effect-',
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'split', [
                'label' => esc_html__('Animate By', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'word',
                'options' => [
                    'word' => esc_html__('Word', 'easy-elementor-addons'),
                    'char' => esc_html__('Letter', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'trigger', [
                'label' => esc_html__('Play', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'scroll',
                'options' => [
                    'scroll' => esc_html__('With the Scroll', 'easy-elementor-addons'),
                    'view' => esc_html__('Once, When in View', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('"With the Scroll" fills the text as the visitor scrolls and reverses when they scroll back.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'start', [
                'label' => esc_html__('Start When Text Reaches (% of screen)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 100]],
                'default' => ['size' => 85],
                'description' => esc_html__('Measured from the top of the screen.', 'easy-elementor-addons'),
                'render_type' => 'template',
                'condition' => [
                    'trigger' => 'scroll'
                ]
            ]
        );

        $this->add_control(
            'end', [
                'label' => esc_html__('Finish When Text Reaches (% of screen)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 100]],
                'default' => ['size' => 35],
                'render_type' => 'template',
                'condition' => [
                    'trigger' => 'scroll'
                ]
            ]
        );

        $this->add_control(
            'stagger', [
                'label' => esc_html__('Delay Between Words (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 300, 'step' => 5]],
                'default' => ['size' => 60],
                'render_type' => 'template',
                'condition' => [
                    'trigger' => 'view'
                ]
            ]
        );

        $this->add_control(
            'duration', [
                'label' => esc_html__('Duration per Word (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 100, 'max' => 2000, 'step' => 50]],
                'default' => ['size' => 600],
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-duration: {{SIZE}}ms',
                ],
                'condition' => [
                    'trigger' => 'view'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style */
        $this->start_controls_section(
            'section_style', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .eead-str'
            ]
        );

        $this->add_control(
            'color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dim_color', [
                'label' => esc_html__('Color Before Reveal', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(127, 127, 127, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-dim: {{VALUE}}',
                ],
                'condition' => [
                    'effect' => 'color'
                ]
            ]
        );

        $this->add_control(
            'highlight_color', [
                'label' => esc_html__('Highlight Color', 'easy-elementor-addons'),
                'description' => esc_html__('For words wrapped in <em>, <strong> or <mark>.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-highlight: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'start_opacity', [
                'label' => esc_html__('Opacity Before Reveal', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 0.9, 'step' => 0.05]],
                'default' => ['size' => 0.15],
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-min: {{SIZE}}',
                ],
                'condition' => [
                    'effect!' => 'color'
                ]
            ]
        );

        $this->add_control(
            'blur', [
                'label' => esc_html__('Blur Before Reveal', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 1, 'max' => 20]],
                'default' => ['size' => 8],
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-blur: {{SIZE}}px',
                ],
                'condition' => [
                    'effect' => 'blur'
                ]
            ]
        );

        $this->add_control(
            'rise', [
                'label' => esc_html__('Rise Distance', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['em', 'px'],
                'range' => [
                    'em' => ['min' => 0.1, 'max' => 2, 'step' => 0.05],
                    'px' => ['min' => 2, 'max' => 80],
                ],
                'default' => ['size' => 0.5, 'unit' => 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-str' => '--eead-str-rise: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'effect' => 'rise'
                ]
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Wrap every word (or letter) in a span while keeping the allowed inline
     * tags, so highlighted words keep their markup.
     */
    private function split_html($html, $by) {
        $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $out = '';
        $count = 0;
        foreach ($parts as $part) {
            if ('<' === $part[0]) {
                $out .= $part;
                continue;
            }
            $tokens = preg_split('/(\s+)/u', $part, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            foreach ($tokens as $token) {
                if (preg_match('/^\s+$/u', $token)) {
                    $out .= ' ';
                    continue;
                }
                if ('char' === $by) {
                    $out .= '<span class="eead-str-word">';
                    // An entity such as &amp; is one letter.
                    preg_match_all('/&#?[a-zA-Z0-9]+;|./us', $token, $chars);
                    foreach ($chars[0] as $char) {
                        $out .= '<span class="eead-str-unit">' . $char . '</span>';
                        $count++;
                    }
                    $out .= '</span>';
                } else {
                    $out .= '<span class="eead-str-unit">' . $token . '</span>';
                    $count++;
                }
            }
        }
        return [$out, $count];
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $allowed = ['em' => [], 'strong' => [], 'mark' => [], 'b' => [], 'i' => [], 'br' => []];
        // Entities stay encoded; only the allowed tags survive.
        $html = wp_kses(trim((string) $settings['text']), $allowed);

        if ('' === $html) {
            return;
        }

        list($split, $count) = $this->split_html($html, 'char' === $settings['split'] ? 'char' : 'word');
        $tag = eead_check_allowed_html_tags($settings['html_tag'], 'h2');

        $this->add_render_attribute('text', [
            'class' => 'eead-str',
            'aria-label' => trim(html_entity_decode(wp_strip_all_tags($html), ENT_QUOTES, get_bloginfo('charset'))),
            'data-settings' => wp_json_encode([
                'trigger' => 'view' === $settings['trigger'] ? 'view' : 'scroll',
                'start' => isset($settings['start']['size']) ? (float) $settings['start']['size'] : 85,
                'end' => isset($settings['end']['size']) ? (float) $settings['end']['size'] : 35,
                'stagger' => isset($settings['stagger']['size']) ? (int) $settings['stagger']['size'] : 60,
                'units' => $count,
            ]),
        ]);
        ?>
        <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string('text'); ?>>
            <span class="eead-str-inner" aria-hidden="true"><?php echo $split; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from wp_kses() output. ?></span>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }

}
