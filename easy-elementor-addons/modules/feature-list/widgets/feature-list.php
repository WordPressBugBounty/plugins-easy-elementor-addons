<?php

namespace EasyElementorAddons\Modules\FeatureList\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Feature List Widget
 */
class FeatureList extends Widget_Base {

    public function get_name() {
        return 'eead-feature-list';
    }

    public function get_title() {
        return esc_html__('Feature List', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-feature-list';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_feature_list_content_settings', [
                'label' => esc_html__('Content Settings', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_type', [
                'label' => esc_html__('Icon Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ]
                ],
                'default' => 'icon',
                'label_block' => false
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $repeater->add_control(
            'img', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_type' => 'image',
                ]
            ]
        );

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Title', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'subtitle', [
                'label' => esc_html__('Subtitle', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.'
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com'
            ]
        );

        // Each icon custom color style
        $repeater->add_control(
            'icon_enable_each_style', [
                'label' => esc_html__('Custom Icon Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on'
            ]
        );

        $repeater->add_control(
            'icon_individual_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list {{CURRENT_ITEM}} .eead-fl-icon-box i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-feature-list {{CURRENT_ITEM}} .eead-fl-icon-box svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .eead-feature-list .eead-fl-style-framed {{CURRENT_ITEM}} .eead-fl-icon-box' => 'border-color: {{VALUE}}'
                ],
                'condition' => [
                    'icon_enable_each_style' => 'on',
                ]
            ]
        );

        $repeater->add_control(
            'icon_individual_bg_color', [
                'label' => esc_html__('Icon Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-style-stacked {{CURRENT_ITEM}} .eead-fl-icon-box' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'icon_enable_each_style' => 'on'
                ]
            ]
        );

        $this->add_control(
            'feature_list', [
                'label' => esc_html__('Feature Item', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [
                        'icon' => [
                            'value' => 'icofont-check-alt',
                        ],
                        'title' => esc_html__('Feature List Item 1', 'easy-elementor-addons'),
                        'subtitle' => 'Consectetur adipisi cing elit',
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna',
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-check-alt',
                        ],
                        'title' => esc_html__('Feature List Item 2', 'easy-elementor-addons'),
                        'subtitle' => 'Rem ipsum dolor sit amet',
                        'easy-elementor-addons',
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna',
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-check-alt',
                        ],
                        'title' => esc_html__('Feature List Item 3', 'easy-elementor-addons'),
                        'subtitle' => 'Seo eiusmod tempor incididunt ut',
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna',
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'additional_settings', [
                'label' => esc_html__('Additional Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title_size', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h4',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'icon_style', [
                'label' => esc_html__('Icon Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'label_block' => false,
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'framed' => esc_html__('Framed', 'easy-elementor-addons'),
                    'stacked' => esc_html__('Stacked', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'default' => 'row',
                'toggle' => false,
                'selectors_dictionary' => [
                    'row' => 'text-align:left; flex-direction:row',
                    'column' => 'text-align:center; flex-direction:column; align-items: center;',
                    'row-reverse' => 'text-align:right; flex-direction:row-reverse',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-item' => '{{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'list_space', [
                'label' => esc_html__('Listing Spacing', 'easy-elementor-addons'),
                'description' => esc_html__('Spacing between feature list', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-feature-list-items' => 'gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Icon Style */
        $this->start_controls_section(
            'style_feature_listing', [
                'label' => esc_html__('Feature Lists', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'feature_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-item' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'feature_border',
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
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-item'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'feature_shadow',
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-item'
            ]
        );

        $this->add_responsive_control(
            'feature_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'feature_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        /* Icon Style */
        $this->start_controls_section(
            'style_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .eead-feature-list .eead-fl-style-framed .eead-fl-icon-box' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'icon_background',
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'color' => [
                    'default' => '#3858f4',
                ],
                'condition' => [
                    'icon_style' => 'stacked',
                ],
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-style-stacked .eead-fl-icon-box'
            ]
        );


        $this->add_responsive_control(
            'icon_space', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 25,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-item' => 'gap: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 250,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box i, {{WRAPPER}} .eead-feature-list .eead-fl-icon-box svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding', [
                'label' => esc_html__('Icon Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_style' => 'framed',
                ]
            ]
        );

        $this->add_control(
            'icon_radius_advanced_show', [
                'label' => esc_html__('Advanced Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'icon_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_radius_advanced_show!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'icon_radius_advanced', [
                'label' => esc_html__('Radius', 'easy-elementor-addons'),
                /* translators: 1: border radius, 2: link. */
                'description' => sprintf(__('For example: <b>%1$s</b> or Go <a href="%2$s" target="_blank">this link</a> and copy and paste the radius value.', 'easy-elementor-addons'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
                'type' => Controls_Manager::TEXT,
                'size_units' => ['px', '%'],
                'default' => '75% 25% 43% 57% / 46% 29% 71% 54%',
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-icon-box' => 'border-radius: {{VALUE}};'
                ],
                'condition' => [
                    'icon_radius_advanced_show' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space', [
                'label' => esc_html__('Title Bottom Space', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#414247',
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-title'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'subtitle_style', [
                'label' => esc_html__('Subtitle', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'subtitle_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-subtitle' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'subtitle_bottom_space', [
                'label' => esc_html__('Title Bottom Space', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-subtitle'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'description_style', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-feature-list .eead-fl-content' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .eead-feature-list .eead-fl-content'
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('feature_list', [
            'class' => [
                'eead-feature-list-items',
                'eead-fl-style-' . $settings['icon_style']
            ],
        ]);
        ?>
        <div class="eead-feature-list">
            <ul <?php $this->print_render_attribute_string('feature_list'); ?>>
                <?php
                foreach ($settings['feature_list'] as $index => $item) {
                    $feature_title_tag = $settings['title_size'];
                    $feature_icon_tag = $item['link']['url'] ? 'a' : 'span';

                    if ($item['link']['url']) {
                        $this->add_render_attribute('link' . $index, [
                            'href' => esc_url($item['link']['url']),
                            'target' => $item['link']['is_external'] ? '_blank' : '',
                            'rel' => $item['link']['nofollow'] ? 'nofollow' : ''
                        ]);
                    }
                    ?>
                    <li class="eead-fl-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                        <div class="eead-fl-icon-box">
                            <<?php echo esc_attr($feature_icon_tag); ?> <?php $this->print_render_attribute_string('link' . $index); ?>>
                                <?php
                                if ($item['icon_type'] == 'icon' && !empty($item['icon']['value'])) {
                                    Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                                } else if ($item['icon_type'] == 'image') {
                                    $this->add_render_attribute(
                                        'feature_list_image' . $index, [
                                            'src' => esc_url($item['img']['url']),
                                            'class' => 'eead-feature-list-img',
                                            'alt' => esc_attr(get_post_meta($item['img']['id'], '_wp_attachment_image_alt', true)),
                                        ]
                                    );
                                    ?>
                                        <img <?php $this->print_render_attribute_string('feature_list_image' . $index); ?> />
                                    <?php
                                }
                                ?>
                            </<?php echo esc_attr($feature_icon_tag); ?>>
                        </div>

                        <div class="eead-fl-content-box">
                            <?php if ($item['title']) { ?>
                                <<?php echo esc_attr(eead_check_allowed_html_tags($feature_title_tag)); ?> class="eead-fl-title">
                                    <<?php echo esc_attr($feature_icon_tag); ?> <?php $this->print_render_attribute_string('link' . $index); ?>>
                                        <?php
                                        echo esc_html($item['title']);
                                        ?>
                                    </<?php echo esc_attr($feature_icon_tag); ?>>
                                </<?php echo esc_attr(eead_check_allowed_html_tags($feature_title_tag)); ?>>
                            <?php } ?>

                            <?php if ($item['subtitle']) { ?>
                                <div class="eead-fl-subtitle">
                                    <?php echo esc_html($item['subtitle']); ?>
                                </div>
                            <?php } ?>

                            <?php if ($item['content']) { ?>
                                <div class="eead-fl-content">
                                    <?php echo wp_kses_post($item['content']); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }

}
