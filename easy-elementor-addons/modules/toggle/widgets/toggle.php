<?php

namespace EasyElementorAddons\Modules\Toggle\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Toggle extends Widget_Base {

    public function get_name() {
        return 'eead-toggle';
    }

    public function get_title() {
        return esc_html__('Toggle Content', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-toggle';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_primary', [
                'label' => esc_html__('Primary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'primary_label', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Annual', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'primary_content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image', 'easy-elementor-addons'),
                    'content' => esc_html__('Content', 'easy-elementor-addons'),
                    'template' => esc_html__('Saved Templates', 'easy-elementor-addons'),
                ],
                'default' => 'content'
            ]
        );

        $this->add_control(
            'primary_templates', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => get_elementor_templates(),
                'condition' => [
                    'primary_content_type' => 'template',
                ]
            ]
        );

        $this->add_control(
            'primary_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Ut posuere bibendum pretium. Nulla sit amet felis sem. Donec eu elit efficitur, vehicula quam sit amet, sodales elit. Praesent ac velit arcu. Sed volutpat vitae nulla sed fermentum. Praesent at pulvinar diam, a iaculis justo. In ullamcorper nec risus sit amet malesuada. Sed tempor, risus sit amet vestibulum dignissim, purus magna venenatis velit, sed facilisis diam arcu at leo. Donec nec lacus in ligula pretium finibus a lobortis ipsum. Nullam eu sem quis magna aliquet cursus. Nam vitae faucibus lorem. Praesent maximus, magna et volutpat scelerisque, neque quam hendrerit ante, nec eleifend est nunc a orci.',
                'condition' => [
                    'primary_content_type' => 'content',
                ]
            ]
        );

        $this->add_control(
            'primary_image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'primary_content_type' => 'image',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'primary_image',
                'default' => 'full',
                'separator' => 'none',
                'condition' => [
                    'primary_content_type' => 'image',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_secondary', [
                'label' => esc_html__('Secondary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'secondary_label', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Lifetime', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'secondary_content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image', 'easy-elementor-addons'),
                    'content' => esc_html__('Content', 'easy-elementor-addons'),
                    'template' => esc_html__('Saved Templates', 'easy-elementor-addons'),
                ],
                'default' => 'content'
            ]
        );

        $this->add_control(
            'secondary_templates', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => get_elementor_templates(),
                'condition' => [
                    'secondary_content_type' => 'template',
                ]
            ]
        );

        $this->add_control(
            'secondary_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Aenean facilisis accumsan nunc, vel maximus ipsum dictum ut. Sed in mauris commodo magna faucibus accumsan. Nunc non purus mi. Phasellus aliquet facilisis orci. Nullam vel tempor est. Aliquam eu elit sit amet nunc ullamcorper imperdiet. Phasellus porta egestas dolor sodales porttitor. Nunc mollis purus id nibh tempus pulvinar. In egestas et magna eu aliquam. Nunc dapibus massa metus, tempor lobortis risus cursus vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed dignissim rutrum tortor, vitae viverra augue tincidunt at. Sed leo nisl, congue ut justo in.',
                'condition' => [
                    'secondary_content_type' => 'content',
                ]
            ]
        );

        $this->add_control(
            'secondary_image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'secondary_content_type' => 'image',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'secondary_image',
                'default' => 'full',
                'separator' => 'none',
                'condition' => [
                    'secondary_content_type' => 'image',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'default_display', [
                'label' => esc_html__('Default Display', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary' => esc_html__('Primary', 'easy-elementor-addons'),
                    'secondary' => esc_html__('Secondary', 'easy-elementor-addons'),
                ],
                'default' => 'primary'
            ]
        );

        $this->add_control(
            'switch_style', [
                'label' => esc_html__('Switch Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'style4' => esc_html__('Style 4', 'easy-elementor-addons'),
                    'style5' => esc_html__('Style 5', 'easy-elementor-addons')
                ],
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'toggle_position', [
                'label' => esc_html__('Toggle Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'before' => esc_html__('Before', 'easy-elementor-addons'),
                    'after' => esc_html__('After', 'easy-elementor-addons'),
                    'before-after' => esc_html__('Before', 'easy-elementor-addons') . ' + ' . esc_html__('After', 'easy-elementor-addons'),
                ],
                'default' => 'before'
            ]
        );

        $this->end_controls_section();

        /* Style Settings */
        $this->start_controls_section(
            'section_toggle_switch_style', [
                'label' => esc_html__('Switch', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'toggle_switch_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                    '{{WRAPPER}} .eead-toggle-switch-container' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_round', [
                'label' => esc_html__('Rounded', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'switch_style' => ['style1', 'style2', 'style5']
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_width', [
                'label' => esc_html__('Switch Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 60,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-toggle-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'switch_style' => ['style1', 'style2', 'style5']
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_width3', [
                'label' => esc_html__('Switch Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 60,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 80,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-toggle-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'switch_style' => 'style3'
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_height', [
                'label' => esc_html__('Switch Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 60,
                    ]
                ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-toggle-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'switch_style' => ['style2', 'style4', 'style5']
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_height1', [
                'label' => esc_html__('Switch Height', 'easy-elementor-addons'),
                'description' => esc_html__('Switch Height will not increase beyond Handle Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 30,
                    ]
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-toggle-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'switch_style' => 'style1'
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_height3', [
                'label' => esc_html__('Switch Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 20,
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-toggle-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'switch_style' => 'style3'
                ]
            ]
        );

        $this->add_control(
            'toggle_handle_size', [
                'label' => esc_html__('Handle Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-container' => '--eead-handle-size: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'condition' => [
                    'switch_style' => 'style1'
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_gap', [
                'label' => esc_html__('Spacing Between Switch & Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 80,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-inner' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'toggle_switch_spacing', [
                'label' => esc_html__('Spacing Between Switch & Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 80,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-switch-before' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-toggle-switch-after' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'switch_box_shadow',
                'label' => esc_html__('Switch Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-toggle-switch-style1 .eead-toggle-switch-checkbox:before, {{WRAPPER}} .eead-toggle-switch-style2 .eead-toggle-switch-checkbox:before',
                'separator' => 'before',
                'condition' => [
                    'switch_style' => ['style1', 'style2']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'switch_handle_box_shadow',
                'label' => esc_html__('Switch Handle Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-toggle-switch-style1 .eead-toggle-switch-checkbox:after, {{WRAPPER}} .eead-toggle-switch-style2 .eead-toggle-switch-checkbox:after, {{WRAPPER}} .eead-toggle-switch-style3 .eead-toggle-slider::before',
                'condition' => [
                    'switch_style' => ['style1', 'style2', 'style3']
                ]
            ]
        );

        $this->start_controls_tabs('tabs_switch');

        $this->start_controls_tab(
            'tab_switch_primary', [
                'label' => esc_html__('Primary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'switch_bg_color', [
                'label' => esc_html__('Switch Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEEEEE',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-bg-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'switch_handle_color', [
                'label' => esc_html__('Switch Handle Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#DCDCDC',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-handle-color: {{VALUE}}',
                ],
                'condition' => [
                    'switch_style!' => 'style4'
                ]
            ]
        );

        $this->add_control(
            'switch_border_color', [
                'label' => esc_html__('Switch Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#BBB',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-border-color: {{VALUE}}',
                ],
                'condition' => [
                    'switch_style' => 'style3'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_switch_secondary', [
                'label' => esc_html__('Secondary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'switch_bg_color_active', [
                'label' => esc_html__('Switch Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#DDD',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-bg-active-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'switch_handle_color_active', [
                'label' => esc_html__('Switch Handle Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00b3ff',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-handle-active-color: {{VALUE}}',
                ],
                'condition' => [
                    'switch_style!' => 'style4'
                ]
            ]
        );

        $this->add_control(
            'switch_border_color_active', [
                'label' => esc_html__('Switch Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#BBB',
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container' => '--eead-toggle-switch-border-active-color: {{VALUE}}',
                ],
                'condition' => [
                    'switch_style' => 'style3'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_label_style', [
                'label' => esc_html__('Labels', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-toggle-label'
            ]
        );

        $this->start_controls_tabs('tabs_label_style');

        $this->start_controls_tab(
            'tab_label_primary', [
                'label' => esc_html__('Primary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'label_text_color_primary', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-label-primary' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'label_active_text_color_primary', [
                'label' => esc_html__('Active Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container:not(.eead-switch-on) .eead-toggle-label-primary' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_label_secondary', [
                'label' => esc_html__('Secondary', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'label_text_color_secondary', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-label-secondary' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'label_active_text_color_secondary', [
                'label' => esc_html__('Active Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-container.eead-switch-on .eead-toggle-label-secondary' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-toggle-section'
            ]
        );

        $this->add_control(
            'content_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-section' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'content_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-toggle-content'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'content_border',
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
                'selector' => '{{WRAPPER}} .eead-toggle-content'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .eead-toggle-content'
            ]
        );

        $this->add_responsive_control(
            'content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-toggle-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render_toggle_content($content) {
        $settings = $this->get_settings_for_display();

        if ($settings[$content . '_content_type'] === 'content') {
            echo $this->parse_text_editor($settings[$content . '_content']);
        } else if ($settings[$content . '_content_type'] === 'image') {
            echo Group_Control_Image_Size::get_attachment_image_html($settings, $content . '_image', $content . '_image');
        } else if ($settings[$content . '_content_type'] === 'template') {
            if (!empty($settings[$content . '_templates'])) {
                $template_id = $settings[$content . '_templates'];
                echo Plugin::$instance->frontend->get_builder_content_for_display($template_id);
            }
        }
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('toggle-container', 'class', 'eead-toggle-container');
        if ($settings['default_display'] == 'secondary') {
            $this->add_render_attribute('toggle-container', 'class', 'eead-switch-on');
        }
        ?>

        <div <?php echo $this->get_render_attribute_string('toggle-container'); ?>>
            <?php
            if ($settings['toggle_position'] === 'before' || $settings['toggle_position'] === 'before-after') {
                $this->before_after_toggle('before');
            }
            ?>

            <div class='eead-toggle-content'>
                <div class="eead-toggle-section eead-toggle-primary">
                    <?php echo $this->render_toggle_content('primary'); ?>
                </div>

                <div class="eead-toggle-section eead-toggle-secondary">
                    <?php echo $this->render_toggle_content('secondary'); ?>
                </div>
            </div>

            <?php
            if ($settings['toggle_position'] === 'after' || $settings['toggle_position'] === 'before-after') {
                $this->before_after_toggle('after');
            }
            ?>
        </div>
        <?php
    }

    protected function before_after_toggle($toggle_position = 'before') {
        $settings = $this->get_settings();

        $this->add_render_attribute('toggle-switch-' . $toggle_position, [
            'class' => ['eead-toggle-switch-container',
                'eead-toggle-switch-' . esc_attr($toggle_position),
                'eead-toggle-switch-' . esc_attr($settings['switch_style'])
            ]
        ]
        );

        $round_switch = $settings['toggle_switch_round'] ? 'yes' : 'no';

        if (in_array($settings['switch_style'], ['style1', 'style2', 'style5']) && $round_switch == 'no') {
            $this->add_render_attribute('toggle-switch-' . $toggle_position, 'class', 'eead-toggle-square-switch');
        }
        ?>

        <div <?php echo $this->get_render_attribute_string('toggle-switch-' . $toggle_position); ?>>
            <div class="eead-toggle-switch-inner">

                <?php if ($settings['primary_label']) { ?>
                    <div class="eead-toggle-label eead-toggle-label-primary">
                        <?php echo esc_html($settings['primary_label']); ?>
                    </div>
                <?php } ?>

                <div class="eead-toggle-switch">
                    <label class="eead-toggle-switch-label">
                        <input class="eead-toggle-switch-checkbox" type="checkbox" <?php checked(('secondary' === $settings['default_display']), true); ?>>

                        <?php if ($settings['switch_style'] == 'style3') { ?>
                            <span class="eead-toggle-slider"></span>
                            <span class="eead-toggle-slider1"></span>
                            <span class="eead-toggle-slider2"></span>
                        <?php } elseif ($settings['switch_style'] == 'style4') {
                            ?>
                            <svg class="eead-svg-toggle" viewBox="0 0 292 142" xmlns="http://www.w3.org/2000/svg">
                                <path class="eead-svg-toggle-background" d="M71 142C31.7878 142 0 110.212 0 71C0 31.7878 31.7878 0 71 0C110.212 0 119 30 146 30C173 30 182 0 221 0C260 0 292 31.7878 292 71C292 110.212 260.212 142 221 142C181.788 142 173 112 146 112C119 112 110.212 142 71 142Z" />
                                <rect class="eead-svg-toggle-icon on" x="64" y="39" width="12" height="64" rx="6" />
                                <path class="eead-svg-toggle-icon off" fill-rule="evenodd" d="M221 91C232.046 91 241 82.0457 241 71C241 59.9543 232.046 51 221 51C209.954 51 201 59.9543 201 71C201 82.0457 209.954 91 221 91ZM221 103C238.673 103 253 88.6731 253 71C253 53.3269 238.673 39 221 39C203.327 39 189 53.3269 189 71C189 88.6731 203.327 103 221 103Z" />
                                <g filter="url('#goo')">
                                    <rect class="eead-svg-toggle-circle-center" x="13" y="42" width="116" height="58" rx="29" fill="#fff" />
                                    <rect class="eead-svg-toggle-circle left" x="14" y="14" width="114" height="114" rx="58" fill="#fff" />
                                    <rect class="eead-svg-toggle-circle right" x="164" y="14" width="114" height="114" rx="58" fill="#fff" />
                                </g>
                                <filter id="goo">
                                    <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10" />
                                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />
                                </filter>
                            </svg>
                        <?php } ?>
                    </label>
                </div>

                <?php if ($settings['secondary_label']) { ?>
                    <div class="eead-toggle-label eead-toggle-label-secondary">
                        <?php echo esc_html($settings['secondary_label']); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php
    }

}
