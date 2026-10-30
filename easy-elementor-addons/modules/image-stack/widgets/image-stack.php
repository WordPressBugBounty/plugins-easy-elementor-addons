<?php

namespace EasyElementorAddons\Modules\ImageStack\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Image Stack Widget
 */
class ImageStack extends Widget_Base {

    public function get_name() {
        return 'eead-image-stack';
    }

    public function get_title() {
        return esc_html__('Image Stack', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-image-stack';
    }

    public function get_keywords() {
        return ['image stack', 'avatars', 'avatar group', 'trusted by', 'social proof', 'team', 'eead'];
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
            'section_images', [
                'label' => esc_html__('Images', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_control(
            'name', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Shown as a tooltip and read out by screen readers.', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com'
            ]
        );

        $this->add_control(
            'images', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['name' => esc_html__('Ava', 'easy-elementor-addons')],
                    ['name' => esc_html__('Noah', 'easy-elementor-addons')],
                    ['name' => esc_html__('Mia', 'easy-elementor-addons')],
                    ['name' => esc_html__('Leo', 'easy-elementor-addons')],
                ],
                'title_field' => '{{{ name || "' . esc_html__('Image', 'easy-elementor-addons') . '" }}}'
            ]
        );

        $this->add_control(
            'extra', [
                'label' => esc_html__('Extra Bubble', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '+2k',
                'description' => esc_html__('A round bubble at the end, such as +2k or +12. Leave empty to hide.', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'on_top', [
                'label' => esc_html__('On Top', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'first',
                'options' => [
                    'first' => esc_html__('First Image', 'easy-elementor-addons'),
                    'last' => esc_html__('Last Image', 'easy-elementor-addons'),
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail',
                'default' => 'medium',
                'exclude' => ['custom']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Trusted by 2,000+ teams', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'subtitle', [
                'label' => esc_html__('Subtitle', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Join them today, free for 14 days.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'text_position', [
                'label' => esc_html__('Text Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'beside',
                'options' => [
                    'beside' => esc_html__('Beside the Images', 'easy-elementor-addons'),
                    'below' => esc_html__('Below the Images', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-imgs-text-',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'title', 'operator' => '!==', 'value' => ''],
                        ['name' => 'subtitle', 'operator' => '!==', 'value' => ''],
                    ]
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
                    '{{WRAPPER}} .eead-imgs' => '{{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Images */
        $this->start_controls_section(
            'section_style_images', [
                'label' => esc_html__('Images', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'size', [
                'label' => esc_html__('Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 20, 'max' => 140]],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => '--eead-imgs-size: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'overlap', [
                'label' => esc_html__('Overlap', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => ['%' => ['min' => 0, 'max' => 70]],
                'default' => ['size' => 30, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => '--eead-imgs-overlap: {{SIZE}}',
                ]
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
                'prefix_class' => 'eead-imgs-shape-'
            ]
        );

        $this->add_control(
            'focus', [
                'label' => esc_html__('Focus Point', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Center', 'easy-elementor-addons'),
                    'center 25%' => esc_html__('Upper (faces in portraits)', 'easy-elementor-addons'),
                    'center top' => esc_html__('Top', 'easy-elementor-addons'),
                    'center bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs-photo img' => 'object-position: {{VALUE}}; transform-origin: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'zoom', [
                'label' => esc_html__('Zoom', 'easy-elementor-addons'),
                'description' => esc_html__('Crop in closer, for example to show just the face in a half-body photo.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => ['%' => ['min' => 100, 'max' => 250]],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => '--eead-imgs-zoom: calc({{SIZE}} / 100)',
                ]
            ]
        );

        $this->add_control(
            'ring_width', [
                'label' => esc_html__('Ring Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 8]],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => '--eead-imgs-ring: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control(
            'ring_color', [
                'label' => esc_html__('Ring Color', 'easy-elementor-addons'),
                'description' => esc_html__('Match it to the background so the images look cut out.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => '--eead-imgs-ring-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'hover_lift', [
                'label' => esc_html__('Lift on Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'prefix_class' => 'eead-imgs-lift-'
            ]
        );

        $this->add_control(
            'extra_heading', [
                'label' => esc_html__('Extra Bubble', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'extra!' => ''
                ]
            ]
        );

        $this->add_control(
            'extra_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs-extra' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'extra!' => ''
                ]
            ]
        );

        $this->add_control(
            'extra_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs-extra' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'extra!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'extra_typography',
                'selector' => '{{WRAPPER}} .eead-imgs-extra',
                'condition' => [
                    'extra!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Text */
        $this->start_controls_section(
            'section_style_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'title', 'operator' => '!==', 'value' => ''],
                        ['name' => 'subtitle', 'operator' => '!==', 'value' => ''],
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'text_gap', [
                'label' => esc_html__('Space From Images', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs' => 'gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-imgs-title'
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'subtitle_typography',
                'label' => esc_html__('Subtitle Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-imgs-subtitle',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'subtitle_color', [
                'label' => esc_html__('Subtitle Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-imgs-subtitle' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = (array) $settings['images'];
        if (empty($items)) {
            return;
        }

        $count = count($items) + ('' !== trim((string) $settings['extra']) ? 1 : 0);
        $first_on_top = 'last' !== $settings['on_top'];
        ?>
        <div class="eead-imgs">
            <ul class="eead-imgs-list">
                <?php
                foreach ($items as $i => $item) {
                    // Which end overlaps the other: the first image on top, or the last.
                    $z = $first_on_top ? $count - $i : $i + 1;
                    $name = trim((string) $item['name']);
                    $url = !empty($item['image']['id']) ? Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'thumbnail', $settings) : '';
                    if (!$url && !empty($item['image']['url'])) {
                        $url = $item['image']['url'];
                    }
                    $alt = '' !== $name ? $name : (!empty($item['image']['id']) ? get_post_meta($item['image']['id'], '_wp_attachment_image_alt', true) : '');
                    $key = 'item-' . $i;
                    $this->add_render_attribute($key, 'class', 'eead-imgs-item');
                    $tag = 'span';
                    if (!empty($item['link']['url'])) {
                        $tag = 'a';
                        $this->add_link_attributes($key, $item['link']);
                    }
                    if ('a' === $tag || '' !== $name) {
                        $this->add_render_attribute($key, 'tabindex', '0');
                    }
                    ?>
                    <li style="z-index: <?php echo (int) $z; ?>">
                        <<?php echo esc_attr($tag); ?> <?php $this->print_render_attribute_string($key); ?>>
                            <?php if ($url) { ?>
                                <span class="eead-imgs-photo"><img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" decoding="async"></span>
                            <?php } ?>
                            <?php if ('' !== $name) { ?>
                                <span class="eead-imgs-tip" aria-hidden="true"><?php echo esc_html($name); ?></span>
                            <?php } ?>
                        </<?php echo esc_attr($tag); ?>>
                    </li>
                    <?php
                }
                if ('' !== trim((string) $settings['extra'])) {
                    ?>
                    <?php // The bubble is the end cap: always above the photo it overlaps, so its text is never covered. ?>
                    <li style="z-index: <?php echo (int) ($count + 1); ?>"><span class="eead-imgs-extra"><?php echo esc_html($settings['extra']); ?></span></li>
                    <?php
                }
                ?>
            </ul>
            <?php if ('' !== $settings['title'] || '' !== $settings['subtitle']) { ?>
                <div class="eead-imgs-text">
                    <?php if ('' !== $settings['title']) { ?>
                        <span class="eead-imgs-title"><?php echo esc_html($settings['title']); ?></span>
                    <?php } ?>
                    <?php if ('' !== $settings['subtitle']) { ?>
                        <span class="eead-imgs-subtitle"><?php echo esc_html($settings['subtitle']); ?></span>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }

}
