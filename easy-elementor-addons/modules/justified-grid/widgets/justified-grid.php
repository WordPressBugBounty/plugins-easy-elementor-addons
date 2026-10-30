<?php

namespace EasyElementorAddons\Modules\JustifiedGrid\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Justified Grid Widget
 */
class JustifiedGrid extends Widget_Base {

    public function get_name() {
        return 'eead-justified-grid';
    }

    public function get_title() {
        return esc_html__('Justified Grid', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-justified-grid';
    }

    public function get_keywords() {
        return ['justified', 'gallery', 'grid', 'photos', 'portfolio', 'flickr', 'eead'];
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
            'section_gallery', [
                'label' => esc_html__('Gallery', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'gallery', [
                'label' => esc_html__('Images', 'easy-elementor-addons'),
                'type' => Controls_Manager::GALLERY,
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'default' => 'medium_large'
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__('Order', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('As Added', 'easy-elementor-addons'),
                    'random' => esc_html__('Random', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'caption', [
                'label' => esc_html__('Caption', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'hover' => esc_html__('On Hover', 'easy-elementor-addons'),
                    'always' => esc_html__('Always Visible', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-jgal-caption-',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'caption_source', [
                'label' => esc_html__('Caption Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'caption',
                'options' => [
                    'caption' => esc_html__('Image Caption', 'easy-elementor-addons'),
                    'title' => esc_html__('Image Title', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('Taken from each image in the Media Library.', 'easy-elementor-addons'),
                'condition' => [
                    'caption!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'link_to', [
                'label' => esc_html__('On Click', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'lightbox',
                'options' => [
                    'lightbox' => esc_html__('Open in Lightbox', 'easy-elementor-addons'),
                    'file' => esc_html__('Open the Image File', 'easy-elementor-addons'),
                    'none' => esc_html__('Nothing', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'row_height', [
                'label' => esc_html__('Row Height', 'easy-elementor-addons'),
                'description' => esc_html__('Rows stretch a little to fill the width, so photos keep their shape with only slight trimming.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 80, 'max' => 600]],
                'default' => ['size' => 240],
                'tablet_default' => ['size' => 200],
                'mobile_default' => ['size' => 140],
                'selectors' => [
                    '{{WRAPPER}} .eead-jgal' => '--eead-jgal-h: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'gap', [
                'label' => esc_html__('Gap', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'default' => ['size' => 8],
                'selectors' => [
                    '{{WRAPPER}} .eead-jgal' => 'gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control(
            'last_row', [
                'label' => esc_html__('Last Row', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'natural',
                'options' => [
                    'natural' => esc_html__('Keep Natural Size', 'easy-elementor-addons'),
                    'fill' => esc_html__('Stretch to Fill', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-jgal-last-'
            ]
        );

        $this->end_controls_section();

        /* Style */
        $this->start_controls_section(
            'section_style', [
                'label' => esc_html__('Images', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-jgal-item' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control(
            'hover_effect', [
                'label' => esc_html__('Hover Effect', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'zoom',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'zoom' => esc_html__('Zoom', 'easy-elementor-addons'),
                    'grayscale' => esc_html__('Grayscale to Color', 'easy-elementor-addons'),
                    'dim' => esc_html__('Dim the Others', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-jgal-hover-'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'caption_typography',
                'label' => esc_html__('Caption Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-jgal-cap',
                'separator' => 'before',
                'condition' => [
                    'caption!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'caption_color', [
                'label' => esc_html__('Caption Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-jgal-cap' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'caption!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'caption_bg', [
                'label' => esc_html__('Caption Shade', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-jgal' => '--eead-jgal-shade: {{VALUE}}',
                ],
                'condition' => [
                    'caption!' => 'none'
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $gallery = (array) $settings['gallery'];
        if (empty($gallery)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="eead-jgal-empty">' . esc_html__('Add images to build the grid.', 'easy-elementor-addons') . '</div>';
            }
            return;
        }
        if ('random' === $settings['order']) {
            shuffle($gallery);
        }
        $slideshow = 'eead-jgal-' . $this->get_id();
        ?>
        <div class="eead-jgal">
            <?php
            foreach ($gallery as $image) {
                $id = !empty($image['id']) ? (int) $image['id'] : 0;
                $src = $id ? Group_Control_Image_Size::get_attachment_image_src($id, 'image', $settings) : (isset($image['url']) ? $image['url'] : '');
                if (!$src) {
                    continue;
                }
                $meta = $id ? wp_get_attachment_metadata($id) : [];
                // Each photo grows in proportion to its width-to-height ratio, which keeps rows level.
                $ratio = (!empty($meta['width']) && !empty($meta['height'])) ? round($meta['width'] / $meta['height'], 4) : 1.5;
                $alt = $id ? get_post_meta($id, '_wp_attachment_image_alt', true) : '';
                $caption = '';
                if ('none' !== $settings['caption'] && $id) {
                    $caption = 'title' === $settings['caption_source'] ? get_the_title($id) : wp_get_attachment_caption($id);
                }
                $full = $id ? wp_get_attachment_url($id) : $src;

                $attrs = 'class="eead-jgal-item" style="--eead-jgal-r: ' . esc_attr($ratio) . '"';
                $tag = 'figure';
                if ('none' !== $settings['link_to'] && $full) {
                    $tag = 'a';
                    $attrs .= ' href="' . esc_url($full) . '"';
                    if ('lightbox' === $settings['link_to']) {
                        $attrs .= ' data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . esc_attr($slideshow) . '"';
                        if ($caption) {
                            $attrs .= ' data-elementor-lightbox-title="' . esc_attr($caption) . '"';
                        }
                    } else {
                        $attrs .= ' target="_blank" rel="noopener"';
                    }
                }
                echo '<' . $tag . ' ' . $attrs . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attributes escaped above.
                echo '<img src="' . esc_url($src) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async">';
                if ($caption) {
                    echo '<span class="eead-jgal-cap">' . esc_html($caption) . '</span>';
                }
                echo '</' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            ?>
        </div>
        <?php
    }

}
