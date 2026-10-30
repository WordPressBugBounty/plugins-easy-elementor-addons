<?php

namespace EasyElementorAddons\Modules\StarRating\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Star Rating Widget
 */
class StarRating extends Widget_Base {

    public function get_name() {
        return 'eead-star-rating';
    }

    public function get_title() {
        return esc_html__('Star Rating', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-star-rating';
    }

    public function get_keywords() {
        return ['rating', 'stars', 'review', 'score', 'testimonial', 'eead'];
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
            'section_rating', [
                'label' => esc_html__('Rating', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'rating',
                'options' => [
                    'rating' => esc_html__('Rating Only', 'easy-elementor-addons'),
                    'review' => esc_html__('Review Card', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'rating', [
                'label' => esc_html__('Rating', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 0.1,
                'default' => 4.6,
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'scale', [
                'label' => esc_html__('Out Of', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '5' => '5',
                    '10' => '10',
                ],
                'description' => esc_html__('Five icons are always shown; a rating out of 10 is scaled to fit.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'number_format', [
                'label' => esc_html__('Show Number', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'value',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'value' => esc_html__('4.6', 'easy-elementor-addons'),
                    'out_of' => esc_html__('4.6/5', 'easy-elementor-addons'),
                    'percent' => esc_html__('92%', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'label', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Excellent', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'caption', [
                'label' => esc_html__('Caption', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Based on 1,240 reviews', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'caption_link', [
                'label' => esc_html__('Caption Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com',
                'condition' => [
                    'caption!' => ''
                ]
            ]
        );

        $this->add_control(
            'stacked', [
                'label' => esc_html__('Stack Lines', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Puts the stars, label and caption on separate lines.', 'easy-elementor-addons'),
                'prefix_class' => 'eead-sr-stacked-',
                'condition' => [
                    'layout' => 'rating'
                ]
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
                'selectors_dictionary' => [
                    'flex-start' => 'justify-content: flex-start; align-items: flex-start; text-align: left',
                    'center' => 'justify-content: center; align-items: center; text-align: center',
                    'flex-end' => 'justify-content: flex-end; align-items: flex-end; text-align: right',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-line, {{WRAPPER}} .eead-sr-review' => '{{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_review', [
                'label' => esc_html__('Review', 'easy-elementor-addons'),
                'condition' => [
                    'layout' => 'review'
                ]
            ]
        );

        $this->add_control(
            'quote', [
                'label' => esc_html__('Review Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Setting it up took ten minutes and our customers noticed the difference the same day. The support team answered every question within an hour.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'name', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Sarah Johnson', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'role', [
                'label' => esc_html__('Role or Company', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Owner, Bloom Studio', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'avatar', [
                'label' => esc_html__('Photo', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'source_icon', [
                'label' => esc_html__('Source Logo', 'easy-elementor-addons'),
                'description' => esc_html__('Where the review was left, such as Google or Facebook.', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-google',
                    'library' => 'fa-brands',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'date', [
                'label' => esc_html__('Date', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('2 weeks ago', 'easy-elementor-addons')
            ]
        );

        $this->end_controls_section();

        /* Style: Stars */
        $this->start_controls_section(
            'section_style_stars', [
                'label' => esc_html__('Stars', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'star_size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 8, 'max' => 80]],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-stars' => 'font-size: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'star_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 30]],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-stars' => 'gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control(
            'star_color', [
                'label' => esc_html__('Filled Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-stars' => '--eead-sr-fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'star_empty_color', [
                'label' => esc_html__('Empty Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-stars' => '--eead-sr-empty: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Text */
        $this->start_controls_section(
            'section_style_text', [
                'label' => esc_html__('Number, Label & Caption', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'line_gap', [
                'label' => esc_html__('Space Between', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-line' => 'gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'number_typography',
                'label' => esc_html__('Number Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-sr-number',
                'condition' => [
                    'number_format!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'number_color', [
                'label' => esc_html__('Number Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-number' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'number_format!' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'label_typography',
                'label' => esc_html__('Label Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-sr-label',
                'separator' => 'before',
                'condition' => [
                    'label!' => ''
                ]
            ]
        );

        $this->add_control(
            'label_color', [
                'label' => esc_html__('Label Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-label' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'caption_typography',
                'label' => esc_html__('Caption Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-sr-caption',
                'separator' => 'before',
                'condition' => [
                    'caption!' => ''
                ]
            ]
        );

        $this->add_control(
            'caption_color', [
                'label' => esc_html__('Caption Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-caption, {{WRAPPER}} .eead-sr-caption a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'caption!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Review Card */
        $this->start_controls_section(
            'section_style_card', [
                'label' => esc_html__('Review Card', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'review'
                ]
            ]
        );

        $this->add_control(
            'card_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-review' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-review' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .eead-sr-review'
            ]
        );

        $this->add_responsive_control(
            'card_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-review' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .eead-sr-review'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'quote_typography',
                'label' => esc_html__('Review Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-sr-quote',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'quote_color', [
                'label' => esc_html__('Review Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-quote' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-sr-name',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'name_color', [
                'label' => esc_html__('Name Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'role_color', [
                'label' => esc_html__('Role & Date Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-role' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'avatar_size', [
                'label' => esc_html__('Photo Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 24, 'max' => 120]],
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-avatar' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'source_color', [
                'label' => esc_html__('Source Logo Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-sr-source' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-sr-source svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    private function format_number($rating, $scale, $format) {
        $value = rtrim(rtrim(number_format_i18n($rating, 1), '0'), '.,');
        if ('' === $value) {
            $value = '0';
        }
        if ('out_of' === $format) {
            return $value . '/' . $scale;
        }
        if ('percent' === $format) {
            return number_format_i18n(round($rating / $scale * 100)) . '%';
        }
        return $value;
    }

    private function render_stars($settings, $rating, $scale) {
        $fraction = $scale > 0 ? max(0, min(1, $rating / $scale)) : 0;
        $filled = $fraction * 5;
        /* translators: 1: rating, 2: highest possible rating */
        $label = sprintf(esc_html__('Rated %1$s out of %2$s', 'easy-elementor-addons'), $this->format_number($rating, $scale, 'value'), $scale);
        ob_start();
        Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);
        $icon = ob_get_clean();
        echo '<span class="eead-sr-stars" role="img" aria-label="' . esc_attr($label) . '">';
        for ($i = 0; $i < 5; $i++) {
            // Each star fills on its own, so a rating like 4.3 shows exactly 30% of the fifth star.
            $part = max(0, min(1, $filled - $i));
            echo '<span class="eead-sr-star"><span class="eead-sr-star-empty">' . $icon . '</span><span class="eead-sr-star-fill" style="width:' . esc_attr(round($part * 100, 1)) . '%">' . $icon . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- icon markup from Icons_Manager.
        }
        echo '</span>';
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $scale = '10' === (string) $settings['scale'] ? 10 : 5;
        $rating = max(0, min($scale, (float) $settings['rating']));
        $format = in_array($settings['number_format'], ['none', 'value', 'out_of', 'percent'], true) ? $settings['number_format'] : 'value';

        ob_start();
        ?>
        <div class="eead-sr-line">
            <?php $this->render_stars($settings, $rating, $scale); ?>
            <?php if ('none' !== $format) { ?>
                <span class="eead-sr-number" aria-hidden="true"><?php echo esc_html($this->format_number($rating, $scale, $format)); ?></span>
            <?php } ?>
            <?php if ('' !== $settings['label']) { ?>
                <span class="eead-sr-label"><?php echo esc_html($settings['label']); ?></span>
            <?php } ?>
            <?php if ('' !== $settings['caption']) { ?>
                <span class="eead-sr-caption">
                    <?php
                    if (!empty($settings['caption_link']['url'])) {
                        $this->add_link_attributes('caption_link', $settings['caption_link']);
                        echo '<a ' . $this->get_render_attribute_string('caption_link') . '>' . esc_html($settings['caption']) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    } else {
                        echo esc_html($settings['caption']);
                    }
                    ?>
                </span>
            <?php } ?>
        </div>
        <?php
        $line = ob_get_clean();

        if ('review' !== $settings['layout']) {
            echo $line; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above with escaping.
            return;
        }
        ?>
        <figure class="eead-sr-review">
            <div class="eead-sr-review-top">
                <?php echo $line; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php if (!empty($settings['source_icon']['value'])) { ?>
                    <span class="eead-sr-source"><?php Icons_Manager::render_icon($settings['source_icon'], ['aria-hidden' => 'true']); ?></span>
                <?php } ?>
            </div>
            <?php if ('' !== $settings['quote']) { ?>
                <blockquote class="eead-sr-quote"><?php echo wp_kses_post(wpautop($settings['quote'])); ?></blockquote>
            <?php } ?>
            <figcaption class="eead-sr-author">
                <?php
                // A small photo, so load the thumbnail rather than the full image.
                $avatar = !empty($settings['avatar']['id']) ? wp_get_attachment_image_url($settings['avatar']['id'], 'thumbnail') : '';
                if (!$avatar && !empty($settings['avatar']['url'])) {
                    $avatar = $settings['avatar']['url'];
                }
                if ($avatar) {
                    ?>
                    <img class="eead-sr-avatar" src="<?php echo esc_url($avatar); ?>" alt="" loading="lazy" decoding="async">
                <?php } ?>
                <span class="eead-sr-who">
                    <?php if ('' !== $settings['name']) { ?>
                        <span class="eead-sr-name"><?php echo esc_html($settings['name']); ?></span>
                    <?php } ?>
                    <?php if ('' !== $settings['role'] || '' !== $settings['date']) { ?>
                        <span class="eead-sr-role"><?php echo esc_html(implode(' · ', array_filter([$settings['role'], $settings['date']], 'strlen'))); ?></span>
                    <?php } ?>
                </span>
            </figcaption>
        </figure>
        <?php
    }

}
