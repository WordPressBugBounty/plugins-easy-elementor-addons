<?php

namespace EasyElementorAddons\Modules\LogoGrid\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class LogoGrid extends Widget_Base {

    public function get_name() {
        return 'eead-logo-grid';
    }

    public function get_title() {
        return esc_html__('Logo Grid', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-logo-grid';
    }

    public function get_keywords() {
        return [];
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return [];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_logo_grid', [
                'label' => esc_html__('Logo Grid', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'logo_image', [
                'label' => esc_html__('Upload Logo Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => 'https://www.your-link.com',
                'default' => [
                    'url' => '',
                ]
            ]
        );

        $this->add_control(
            'logos', [
                'label' => esc_html__('Add Logos', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'logo_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'logo_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'logo_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__('Logo Image', 'easy-elementor-addons')
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'image',
                'label' => esc_html__('Image Size', 'easy-elementor-addons'),
                'default' => 'full'
            ]
        );

        $this->add_control(
            'title_html_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => eead_html_tags(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'logo_grid_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'columns', [
                'label' => esc_html__('Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'
                ],
                'prefix_class' => 'eead-lg%s-col-',
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'logos_spacing', [
                'label' => esc_html__('Logos Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => ['size' => 10],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid' => '--eead-logo-grid-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'logos_vertical_align', [
                'label' => esc_html__('Vertical Align', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'logos_horizontal_align', [
                'label' => esc_html__('Horizontal Align', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item' => 'align-items: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logos_width', [
                'label' => esc_html__('Image Max Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 800,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        /* Style */
        $this->start_controls_section(
            'section_logos_style', [
                'label' => esc_html__('Logos', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'logo_container_border_radius', [
                'label' => esc_html__('Container Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius', [
                'label' => esc_html__('Image Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'logo_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'border_type', [
                'label' => esc_html__('Border Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                    'around-container' => esc_html__('Around Container', 'easy-elementor-addons'),
                    'around-image' => esc_html__('Around Image', 'easy-elementor-addons'),
                    'table-cell' => esc_html__('Table Cell', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'border_width', [
                'label' => esc_html__('Border Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 1
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid' => '--eead-logo-grid-border-size: {{SIZE}}px;',
                ],
                'condition' => [
                    'border_type!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid' => '--eead-logo-grid-border-color: {{VALUE}}',
                ],
                'default' => '#000',
                'condition' => [
                    'border_type!' => 'none'
                ]
            ]
        );

        $this->start_controls_tabs('tabs_logos_style');

        $this->start_controls_tab(
            'tab_logos_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'logo_bg',
                'types' => ['none', 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-logo-grid .eead-grid-item'
            ]
        );


        $this->add_control(
            'grayscale_normal', [
                'label' => esc_html__('Enable Grayscale', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'opacity_normal', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'size' => 1
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item img' => 'opacity: {{SIZE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'logo_box_shadow_normal',
                'selector' => '{{WRAPPER}} .eead-logo-grid .eead-grid-item',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_logos_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'logos_bg_hover',
                'types' => ['none', 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-logo-grid .eead-grid-item:hover'
            ]
        );

        $this->add_control(
            'grayscale_hover', [
                'label' => esc_html__('Enable Grayscale', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );

        $this->add_control(
            'opacity_hover', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'size' => 1
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item:hover img' => 'opacity: {{SIZE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'logo_box_shadow_hover',
                'selector' => '{{WRAPPER}} .eead-logo-grid .eead-grid-item:hover',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_logo_title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-logo-grid-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-logo-grid .eead-logo-grid-title'
            ]
        );

        $this->add_responsive_control(
            'title_spacing', [
                'label' => esc_html__('Top Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-logo-grid .eead-grid-item' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('logo-grid', 'class', 'eead-logo-grid');
        $this->add_render_attribute('logo-grid', 'class', 'eead-logo-grid-border-' . esc_attr($settings['border_type']));

        if ($settings['grayscale_normal'] === 'yes') {
            $this->add_render_attribute('logo-grid', 'class', 'grayscale-normal');
        }

        if ($settings['grayscale_hover'] === 'yes') {
            $this->add_render_attribute('logo-grid', 'class', 'grayscale-hover');
        }
        ?>

        <div <?php echo $this->get_render_attribute_string('logo-grid'); ?>>
            <?php
            $count = 1;
            $logo_count = count($settings['logos']);
            $last_row_items = $logo_count % $settings['columns'] == 0 ? $settings['columns'] : $logo_count % $settings['columns'];
            $tablet_last_row_items = $logo_count % $settings['columns_tablet'] == 0 ? $settings['columns_tablet'] : $logo_count % $settings['columns_tablet'];
            $mobile_last_row_items = $logo_count % $settings['columns_mobile'] == 0 ? $settings['columns_mobile'] : $logo_count % $settings['columns_mobile'];

            foreach ($settings['logos'] as $item) {
                if (!empty($item['logo_image']['url'])) {
                    $classes = [
                        'eead-grid-item',
                        'eead-grid-item-' . $count,
                        ($logo_count - $count < $last_row_items) ? 'eead-last-row' : '',
                        ($logo_count - $count < $tablet_last_row_items) ? 'eead-tablet-last-row' : '',
                        ($logo_count - $count < $mobile_last_row_items) ? 'eead-mobile-last-row' : '',
                    ];
                    $this->add_render_attribute('logo-item' . $count, ['class' => array_filter($classes)]);
                    ?>
                    <div <?php echo $this->get_render_attribute_string('logo-item' . $count); ?>>
                        <?php
                        if (!empty($item['link']['url'])) {
                            $this->add_link_attributes('logo-link' . $count, $item['link']);
                            echo '<a ' . $this->get_render_attribute_string('logo-link' . $count) . '>';
                        }

                        $image_alt = Control_Media::get_image_alt($item['logo_image']);
                        $image_url = Group_Control_Image_Size::get_attachment_image_src($item['logo_image']['id'], 'image', $settings);

                        if (!$image_url) {
                            $image_url = $item['logo_image']['url'];
                        }

                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" />';

                        if (!empty($item['link']['url'])) {
                            echo '</a>';
                        }

                        if (!empty($item['title'])) {
                            echo '<' . esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])) . ' class="eead-logo-grid-title">';

                            if (!empty($item['link']['url'])) {
                                echo '<a ' . $this->get_render_attribute_string('logo-link' . $count) . '>';
                            }

                            echo esc_html($item['title']);

                            if (!empty($item['link']['url'])) {
                                echo '</a>';
                            }
                            echo '</' . esc_attr(eead_check_allowed_html_tags($settings['title_html_tag'])) . '>';
                        }
                        ?>
                    </div>

                    <?php
                }
                $count++;
            }
            ?>
        </div>
        <?php
    }

}
