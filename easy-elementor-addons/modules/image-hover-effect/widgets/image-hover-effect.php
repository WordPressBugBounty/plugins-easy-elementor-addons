<?php

namespace EasyElementorAddons\Modules\ImageHoverEffect\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Image Hover Effect Widget
 */
class ImageHoverEffect extends Widget_Base {

    public function get_name() {
        return 'eead-image-hover-effect';
    }

    public function get_title() {
        return esc_html__('Image Hover Effects', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-image-hover-effect';
    }

    public function get_keywords() {
        return ['image hover', 'hover effect', 'caption', 'image box', 'overlay', 'eead'];
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

    private function effects() {
        return [
            'fade' => esc_html__('Fade In', 'easy-elementor-addons'),
            'zoom-in' => esc_html__('Zoom In', 'easy-elementor-addons'),
            'zoom-out' => esc_html__('Zoom Out', 'easy-elementor-addons'),
            'slide-up' => esc_html__('Slide Up', 'easy-elementor-addons'),
            'slide-down' => esc_html__('Slide Down', 'easy-elementor-addons'),
            'slide-left' => esc_html__('Slide Left', 'easy-elementor-addons'),
            'slide-right' => esc_html__('Slide Right', 'easy-elementor-addons'),
            'push-up' => esc_html__('Push Up', 'easy-elementor-addons'),
            'reveal' => esc_html__('Title Always, Text on Hover', 'easy-elementor-addons'),
            'blur' => esc_html__('Blur', 'easy-elementor-addons'),
            'grayscale' => esc_html__('Grayscale to Color', 'easy-elementor-addons'),
            'rotate' => esc_html__('Rotate & Zoom', 'easy-elementor-addons'),
            'shine' => esc_html__('Shine', 'easy-elementor-addons'),
            'door' => esc_html__('Doors', 'easy-elementor-addons'),
            'circle' => esc_html__('Circle Reveal', 'easy-elementor-addons'),
            'border' => esc_html__('Border Reveal', 'easy-elementor-addons'),
        ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'default' => 'large'
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Mountain Escape', 'easy-elementor-addons'),
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h3',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'rows' => 3,
                'default' => esc_html__('Three days of trails, lakes and starry skies.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'link_on', [
                'label' => esc_html__('Link On', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'box',
                'options' => [
                    'box' => esc_html__('Whole Box', 'easy-elementor-addons'),
                    'button' => esc_html__('Button', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'link[url]!' => ''
                ]
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Explore', 'easy-elementor-addons'),
                'condition' => [
                    'link[url]!' => '',
                    'link_on' => 'button'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_effect', [
                'label' => esc_html__('Hover Effect', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'effect', [
                'label' => esc_html__('Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide-up',
                'options' => $this->effects(),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'duration', [
                'label' => esc_html__('Speed (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 100, 'max' => 2000, 'step' => 50]],
                'default' => ['size' => 450],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => '--eead-ihe-speed: {{SIZE}}ms',
                ]
            ]
        );

        $this->add_control(
            'always_show_touch', [
                'label' => esc_html__('Show Content on Touch Screens', 'easy-elementor-addons'),
                'description' => esc_html__('Touch screens have no hover, so the content is shown from the start.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'prefix_class' => 'eead-ihe-touch-'
            ]
        );

        $this->add_responsive_control(
            'content_v_position', [
                'label' => esc_html__('Vertical Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'options' => [
                    'flex-start' => ['title' => esc_html__('Top', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-top'],
                    'center' => ['title' => esc_html__('Middle', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-middle'],
                    'flex-end' => ['title' => esc_html__('Bottom', 'easy-elementor-addons'), 'icon' => 'eicon-v-align-bottom'],
                ],
                'default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-content' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors_dictionary' => [
                    'left' => 'text-align: left; --eead-ihe-button-align: flex-start',
                    'center' => 'text-align: center; --eead-ihe-button-align: center',
                    'right' => 'text-align: right; --eead-ihe-button-align: flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-content' => '{{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Box */
        $this->start_controls_section(
            'section_style_box', [
                'label' => esc_html__('Box', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'ratio', [
                'label' => esc_html__('Shape', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '4/3',
                'options' => [
                    '1/1' => esc_html__('Square (1:1)', 'easy-elementor-addons'),
                    '4/3' => esc_html__('Landscape (4:3)', 'easy-elementor-addons'),
                    '3/2' => esc_html__('Landscape (3:2)', 'easy-elementor-addons'),
                    '16/9' => esc_html__('Wide (16:9)', 'easy-elementor-addons'),
                    '3/4' => esc_html__('Portrait (3:4)', 'easy-elementor-addons'),
                    '2/3' => esc_html__('Portrait (2:3)', 'easy-elementor-addons'),
                    'custom' => esc_html__('Custom Height', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => 'aspect-ratio: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 100, 'max' => 1000],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'default' => ['size' => 360, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => 'aspect-ratio: auto; height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'ratio' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'image_position', [
                'label' => esc_html__('Image Focus', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => esc_html__('Center', 'easy-elementor-addons'),
                    'center top' => esc_html__('Top', 'easy-elementor-addons'),
                    'center bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                    'left center' => esc_html__('Left', 'easy-elementor-addons'),
                    'right center' => esc_html__('Right', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-image img' => 'object-position: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .eead-ihe'
            ]
        );

        $this->add_responsive_control(
            'box_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .eead-ihe'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'box_shadow_hover',
                'label' => esc_html__('Box Shadow on Hover', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ihe:hover, {{WRAPPER}} .eead-ihe:focus-within'
            ]
        );

        $this->end_controls_section();

        /* Style: Overlay */
        $this->start_controls_section(
            'section_style_overlay', [
                'label' => esc_html__('Overlay', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'overlay',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-ihe-overlay',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => 'rgba(11, 12, 16, 0.6)'],
                ]
            ]
        );

        $this->add_control(
            'overlay_opacity', [
                'label' => esc_html__('Overlay Opacity on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.05]],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => '--eead-ihe-overlay: {{SIZE}}',
                ]
            ]
        );

        $this->add_control(
            'border_reveal_color', [
                'label' => esc_html__('Reveal Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => '--eead-ihe-line: {{VALUE}}',
                ],
                'condition' => [
                    'effect' => 'border'
                ]
            ]
        );

        $this->add_control(
            'blur_amount', [
                'label' => esc_html__('Blur Amount', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 1, 'max' => 20]],
                'default' => ['size' => 6],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe' => '--eead-ihe-blur: {{SIZE}}px',
                ],
                'condition' => [
                    'effect' => 'blur'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Content Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Title & Description */
        $this->start_controls_section(
            'section_style_text', [
                'label' => esc_html__('Title & Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ihe-title',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'title_spacing', [
                'label' => esc_html__('Space Below Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-title' => 'margin-bottom: {{SIZE}}px',
                ],
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'desc_typography',
                'label' => esc_html__('Description Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ihe-desc',
                'separator' => 'before',
                'condition' => [
                    'description!' => ''
                ]
            ]
        );

        $this->add_control(
            'desc_color', [
                'label' => esc_html__('Description Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-desc' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'description!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Button */
        $this->start_controls_section(
            'section_style_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'link[url]!' => '',
                    'link_on' => 'button'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-ihe-button'
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button' => 'background-color: {{VALUE}}',
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
            'button_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button:hover, {{WRAPPER}} .eead-ihe-button:focus-visible' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button:hover, {{WRAPPER}} .eead-ihe-button:focus-visible' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ihe-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $effect = array_key_exists($settings['effect'], $this->effects()) ? $settings['effect'] : 'slide-up';
        $has_link = !empty($settings['link']['url']);
        $box_link = $has_link && 'box' === $settings['link_on'];
        $title_tag = eead_check_allowed_html_tags($settings['title_tag'], 'h3');

        $this->add_render_attribute('box', 'class', ['eead-ihe', 'eead-ihe-' . $effect]);
        if ($box_link) {
            $this->add_link_attributes('box', $settings['link']);
        } else {
            // Lets keyboard users reach the content that hover reveals.
            $this->add_render_attribute('box', 'tabindex', '0');
        }

        $image_html = '';
        if (!empty($settings['image']['id'])) {
            $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'image', 'image');
        } elseif (!empty($settings['image']['url'])) {
            $image_html = '<img src="' . esc_url($settings['image']['url']) . '" alt="">';
        }

        $tag = $box_link ? 'a' : 'div';
        ?>
        <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string('box'); ?>>
            <div class="eead-ihe-image"><?php echo wp_kses_post($image_html); ?></div>
            <div class="eead-ihe-overlay" aria-hidden="true"></div>
            <?php if ('border' === $effect) { ?>
                <span class="eead-ihe-lines" aria-hidden="true"></span>
            <?php } ?>
            <div class="eead-ihe-content">
                <?php if ('' !== $settings['title']) { ?>
                    <<?php echo esc_attr($title_tag); ?> class="eead-ihe-title"><?php echo esc_html($settings['title']); ?></<?php echo esc_attr($title_tag); ?>>
                <?php } ?>
                <?php if ('' !== $settings['description']) { ?>
                    <div class="eead-ihe-desc"><?php echo wp_kses_post(nl2br($settings['description'])); ?></div>
                <?php } ?>
                <?php
                if ($has_link && !$box_link && '' !== $settings['button_text']) {
                    $this->add_link_attributes('button', $settings['link']);
                    $this->add_render_attribute('button', 'class', 'eead-ihe-button');
                    ?>
                    <a <?php $this->print_render_attribute_string('button'); ?>><?php echo esc_html($settings['button_text']); ?></a>
                <?php } ?>
            </div>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }

}
