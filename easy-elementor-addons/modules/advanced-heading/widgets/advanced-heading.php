<?php

namespace EasyElementorAddons\Modules\AdvancedHeading\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Heading Widget
 */
class AdvancedHeading extends Widget_Base {

    public function get_name() {
        return 'eead-advanced-heading';
    }

    public function get_title() {
        return esc_html__('Advanced Heading', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-advanced-heading';
    }

    public function get_keywords() {
        return ['heading', 'title'];
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return [];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content_heading', [
                'label' => esc_html__('Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'toggle' => false,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'eead-ah-align-'
            ]
        );

        $this->add_control(
            'sub_heading', [
                'label' => esc_html__('Sub Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your prefix title', 'easy-elementor-addons'),
                'default' => esc_html__('SUB HEADING', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'main_heading', [
                'label' => esc_html__('Main Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your main heading here', 'easy-elementor-addons'),
                'default' => esc_html__('Main Heading Text', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'split_main_heading', [
                'label' => esc_html__('Split Main Heading', 'easy-elementor-addons'),
                'separator' => 'before',
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $this->add_control(
            'split_text', [
                'label' => esc_html__('Split Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('Enter your split text', 'easy-elementor-addons'),
                'default' => esc_html__('Split Text', 'easy-elementor-addons'),
                'condition' => [
                    'split_main_heading' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'http://your-link.com',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'header_size', [
                'label' => esc_html__('HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h3',
                'label_block' => true
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_advanced_heading', [
                'label' => esc_html__('Advanced Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'advanced_heading_visibility', [
                'label' => esc_html__('Enable', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'advanced_heading', [
                'label' => esc_html__('Advanced Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your advanced heading', 'easy-elementor-addons'),
                'description' => esc_html__('This heading will show in the background.', 'easy-elementor-addons'),
                'default' => esc_html__('Background Text', 'easy-elementor-addons'),
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'advanced_heading_h_align', [
                'label' => esc_html__('Horizontal Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
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
                    '{{WRAPPER}} .eead-ah-adv-heading' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'advanced_heading_v_align', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ah-adv-heading' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'advanced_heading_x_position', [
                'label' => esc_html__('X Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-adv-heading-offset-x:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'advanced_heading_y_position', [
                'label' => esc_html__('Y Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -800,
                        'max' => 800,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-adv-heading-offset-y:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'advanced_heading_rotate', [
                'label' => esc_html__('Rotate', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-adv-heading-rotate:{{SIZE}}deg',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'advanced_heading_origin', [
                'label' => esc_html__('Rotate Origin', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => get_element_position(),
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-adv-heading-rotate-origin:{{VALUE}}',
                ],
                'condition' => [
                    'advanced_heading_visibility' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'advanced_heading_hide', [
                'label' => esc_html__('Hide On Devices', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    'tablet' => esc_html__('Tablet', 'easy-elementor-addons'),
                    'mobile' => esc_html__('Mobile', 'easy-elementor-addons'),
                ],
                'separator' => 'before',
                'condition' => [
                    'advanced_heading_visibility' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_sub_heading', [
                'label' => esc_html__('Sub Heading', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'sub_heading!' => '',
                ]
            ]
        );

        $this->add_control(
            'sub_heading_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-sub-heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'sub_heading_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-sub-heading'
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'sub_heading_text_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-sub-heading'
            ]
        );

        $this->add_control(
            'sub_heading_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'easy-elementor-addons'),
                    'line' => esc_html__('Line', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'sub_heading_line_position', [
                'label' => esc_html__('Line Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__('After', 'easy-elementor-addons'),
                    'left' => esc_html__('Before', 'easy-elementor-addons'),
                    'left-right' => esc_html__('After and Before', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'sub_heading_style' => 'line',
                ]
            ]
        );

        $this->add_control(
            'sub_heading_line_color', [
                'label' => esc_html__('Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-sh-line-color: {{VALUE}};',
                ],
                'condition' => [
                    'sub_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'sub_heading_line_width', [
                'label' => esc_html__('Line Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-sh-line-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'sub_heading_line_height', [
                'label' => esc_html__('Line Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 48,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-sh-line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'sub_heading_line_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200,
                    ]
                ],
                'condition' => [
                    'sub_heading_style' => 'line',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-ah-sub-heading' => '--eead-ah-sh-line-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_main_heading', [
                'label' => esc_html__('Main Heading', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'main_heading!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'main_heading_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'main_heading_text_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text'
            ]
        );

        $this->start_controls_tabs('tabs_style_main_heading');

        $this->start_controls_tab(
            'tab_main_text', [
                'label' => esc_html__('Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'main_heading_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'main_heading_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_split_text', [
                'label' => esc_html__('Split Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'mainh_split_text_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text .eead-ah-split-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'split_main_heading' => 'yes',
                    'split_text!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'mainh_split_text_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text .eead-ah-split-text',
                'condition' => [
                    'split_main_heading' => 'yes',
                    'split_text!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'split_text_space', [
                'label' => esc_html__('Split Space', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-main-heading-text' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'split_main_heading' => 'yes'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'main_heading_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'easy-elementor-addons'),
                    'line' => esc_html__('Line', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'main_heading_line_position', [
                'label' => esc_html__('Line Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'right' => esc_html__('After', 'easy-elementor-addons'),
                    'left' => esc_html__('Before', 'easy-elementor-addons'),
                    'left-right' => esc_html__('After and Before', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'main_heading_style' => 'line',
                ]
            ]
        );

        $this->add_control(
            'main_heading_line_color', [
                'label' => esc_html__('Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-mh-line-color: {{VALUE}};',
                ],
                'condition' => [
                    'main_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'main_heading_line_width', [
                'label' => esc_html__('Line Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-mh-line-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'main_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'main_heading_line_height', [
                'label' => esc_html__('Line Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 48,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-mh-line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'main_heading_style' => 'line',
                ]
            ]
        );

        $this->add_responsive_control(
            'main_heading_line_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'condition' => [
                    'main_heading_style' => 'line',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading' => '--eead-ah-mh-line-gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_advanced_heading', [
                'label' => esc_html__('Advanced Heading', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'advanced_heading!' => '',
                    'advanced_heading_visibility' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'advanced_heading_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-adv-heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'advanced_heading_typography',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-adv-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'advanced_heading_shadow',
                'selector' => '{{WRAPPER}} .eead-advanced-heading .eead-ah-adv-heading'
            ]
        );

        $this->add_control(
            'advanced_heading_opacity', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.05,
                        'max' => 1,
                        'step' => 0.05,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-advanced-heading .eead-ah-adv-heading' => 'opacity: {{SIZE}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['sub_heading']) && empty($settings['advanced_heading']) && empty($settings['main_heading'])) {
            return;
        }
        ?>
        <div class="eead-advanced-heading">
            <?php
            echo $this->get_sub_heading();
            echo $this->get_advanced_heading();
            echo $this->get_main_heading();
            ?>
        </div>
        <?php
    }

    protected function get_sub_heading() {
        $settings = $this->get_settings_for_display();
        $sub_heading = '';

        if ($settings['sub_heading']) {
            $sub_heading .= '<div class="eead-ah-sub-heading eead-ah-line-' . esc_attr($settings['sub_heading_line_position']) . '"><span>';
            $sub_heading .= esc_html($settings['sub_heading']);
            $sub_heading .= '</span></div>';
        }
        return $sub_heading;
    }

    protected function get_main_heading() {
        $settings = $this->get_settings_for_display();
        $main_heading = $heading = '';

        if ($settings['main_heading']) {
            $main_heading .= '<span class="eead-ah-main-heading-wrap">';
            $main_heading .= '<span class="eead-ah-main-heading-text">';
            $main_heading .= esc_html($settings['main_heading']);
            if ($settings['split_main_heading'] == 'yes' && !empty($settings['split_text'])) {
                $main_heading .= '<span class="eead-ah-split-text"> ';
                $main_heading .= esc_html($settings['split_text']);
                $main_heading .= '</span>';
            }
            $main_heading .= '</span>';
            $main_heading .= '</span>';

            if (!empty($settings['link']['url'])) {
                $this->add_render_attribute('url', 'href', $settings['link']['url']);

                if ($settings['link']['is_external']) {
                    $this->add_render_attribute('url', 'target', '_blank');
                }

                if (!empty($settings['link']['nofollow'])) {
                    $this->add_render_attribute('url', 'rel', 'nofollow');
                }
            }

            $heading .= '<' . esc_attr(eead_check_allowed_html_tags($settings['header_size'])) . ' class="eead-ah-main-heading eead-ah-line-' . esc_attr($settings['main_heading_line_position']) . '">';
            if (!empty($settings['link']['url'])) {
                $heading .= wp_kses_post(sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $main_heading));
            } else {
                $heading .= wp_kses_post($main_heading);
            }
            $heading .= '</' . esc_attr(eead_check_allowed_html_tags($settings['header_size'])) . '>';
        }

        return $heading;
    }

    protected function get_advanced_heading() {
        $settings = $this->get_settings_for_display();
        $advanced_heading = '';

        if ($settings['advanced_heading'] && $settings['advanced_heading_visibility'] == 'yes') {
            $this->add_render_attribute('advanced_heading', 'class',
                [
                    'eead-ah-adv-heading',
                    $settings['advanced_heading_hide'] ? 'eead-hide-' . implode('-', $settings['advanced_heading_hide']) : '',
                ]
            );

            $advanced_heading .= '<div ' . $this->get_render_attribute_string('advanced_heading') . '>';
            $advanced_heading .= esc_html($settings['advanced_heading']);
            $advanced_heading .= '</div>';
        }
        return $advanced_heading;
    }

}
