<?php

namespace EasyElementorAddons\Modules\DualHeading\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Dual Heading Widget
 */
class DualHeading extends Widget_Base {

    public function get_name() {
        return 'eead-dual-heading';
    }

    public function get_title() {
        return esc_html__('Dual Heading', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-dual-heading';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return [];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_dual_heading', [
                'label' => esc_html__('Dual Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'first_heading', [
                'label' => esc_html__('First Heading Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'rows' => 3,
                'default' => esc_html__('Dual', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'second_heading', [
                'label' => esc_html__('Second Heading Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'rows' => 3,
                'default' => esc_html__('Heading', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => 'https://www.your-link.com'
            ]
        );

        $this->add_control(
            'heading_html_tag', [
                'label' => esc_html__('HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'default' => 'h3',
                'options' => eead_html_tags()
            ]
        );

        $this->add_responsive_control(
            'horizontal_align', [
                'label' => esc_html__('Horizontal Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-heading' => 'justify-content: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'vertical_align', [
                'label' => esc_html__('Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-heading' => 'align-items: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dual-heading' => 'column-gap: calc({{SIZE}}{{UNIT}}/2);',
                ]
            ]
        );

        $this->end_controls_section();

        /* First Heading Styles */
        $this->start_controls_section(
            'first_section_style', [
                'label' => esc_html__('First Part', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'first_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-first-text',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'dual_header_first_back_clip', [
                'label' => esc_html__('Heading Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'color',
                'options' => [
                    'color' => esc_html__('Normal', 'easy-elementor-addons'),
                    'clipped' => esc_html__('Clipped Background', 'easy-elementor-addons'),
                    'stroke' => esc_html__('Stroke', 'easy-elementor-addons'),
                ],
                'label_block' => true
            ]
        );

        $this->add_control(
            'dual_header_first_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'dual_header_first_back_clip' => 'color'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'dual_header_first_background',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'dual_header_first_back_clip' => 'color'
                ],
                'selector' => '{{WRAPPER}} .eead-first-text'
            ]
        );

        $this->add_control(
            'dual_header_first_stroke_text_color', [
                'label' => esc_html__('Stroke Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'dual_header_first_back_clip' => 'stroke',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => '-webkit-text-stroke-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dual_header_first_stroke_color', [
                'label' => esc_html__('Stroke Fill Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0)',
                'condition' => [
                    'dual_header_first_back_clip' => 'stroke'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => '-webkit-text-fill-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dual_header_first_stroke_width', [
                'label' => esc_html__('Stroke Fill Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'condition' => [
                    'dual_header_first_back_clip' => 'stroke'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => '-webkit-text-stroke-width: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'dual_header_first_clipped_background',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'dual_header_first_back_clip' => 'clipped',
                ],
                'selector' => '{{WRAPPER}} .eead-first-text'
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'first_border',
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
                'selector' => '{{WRAPPER}} .eead-first-text',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'first_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'first_text_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-first-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'first_text_shadow',
                'selector' => '{{WRAPPER}} .eead-first-text',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'first_box_shadow',
                'selector' => '{{WRAPPER}} .eead-first-text',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        /* Second Heading Styles */
        $this->start_controls_section(
            'second_section_style', [
                'label' => esc_html__('Second Part', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'second_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-second-text',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'dual_header_second_back_clip', [
                'label' => esc_html__('Heading Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'color',
                'options' => [
                    'color' => esc_html__('Normal', 'easy-elementor-addons'),
                    'clipped' => esc_html__('Clipped Background', 'easy-elementor-addons'),
                    'stroke' => esc_html__('Stroke', 'easy-elementor-addons'),
                ],
                'label_block' => true
            ]
        );

        $this->add_control(
            'dual_header_second_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'dual_header_second_back_clip' => 'color'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'dual_header_second_background',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'dual_header_second_back_clip' => 'color'
                ],
                'selector' => '{{WRAPPER}} .eead-second-text'
            ]
        );

        $this->add_control(
            'dual_header_second_stroke_text_color', [
                'label' => esc_html__('Stroke Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'dual_header_second_back_clip' => 'stroke',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => '-webkit-text-stroke-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dual_header_second_stroke_color', [
                'label' => esc_html__('Stroke Fill Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0)',
                'condition' => [
                    'dual_header_second_back_clip' => 'stroke'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => '-webkit-text-fill-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dual_header_second_stroke_width', [
                'label' => esc_html__('Stroke Fill Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'condition' => [
                    'dual_header_second_back_clip' => 'stroke'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => '-webkit-text-stroke-width: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'dual_header_second_clipped_background',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'dual_header_second_back_clip' => 'clipped',
                ],
                'selector' => '{{WRAPPER}} .eead-second-text'
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'second_border',
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
                'selector' => '{{WRAPPER}} .eead-second-text',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'second_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'second_text_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-second-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name' => 'second_text_shadow',
                'selector' => '{{WRAPPER}} .eead-second-text',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'second_box_shadow',
                'selector' => '{{WRAPPER}} .eead-second-text',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('first_heading', 'basic');
        $this->add_render_attribute('first_heading', 'class', 'eead-first-text');

        $this->add_inline_editing_attributes('second_heading', 'basic');
        $this->add_render_attribute('second_heading', 'class', 'eead-second-text');

        if ($settings['dual_header_first_back_clip'] == 'clipped') {
            $this->add_render_attribute('first_heading', 'class', 'eead-clipped');
        }

        if ($settings['dual_header_second_back_clip'] == 'clipped') {
            $this->add_render_attribute('second_heading', 'class', 'eead-clipped');
        }

        $heading_text = '';

        if ($settings['first_heading']) {
            $heading_text = sprintf('<span %1$s>%2$s</span>', $this->get_render_attribute_string('first_heading'), esc_html($settings['first_heading']));
        }
        $heading_text .= '&nbsp;';
        if ($settings['second_heading']) {
            $heading_text .= sprintf('<span %1$s>%2$s</span>', $this->get_render_attribute_string('second_heading'), esc_html($settings['second_heading']));
        }

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('heading-link', [
                'class' => 'eead-heading-link',
                'href' => esc_url($settings['link']['url'])
            ]);
            if ($settings['link']['is_external']) {
                $this->add_render_attribute('heading-link', 'target', '_blank');
            }
        }

        if ($settings['first_heading'] || $settings['second_heading']) {
            ?>
            <<?php echo esc_attr(eead_check_allowed_html_tags($settings['heading_html_tag'])); ?> class="eead-dual-heading">

                <?php
                if (!empty($settings['link']['url'])) {
                    printf('<a %1$s>', $this->get_render_attribute_string('heading-link'));
                }

                echo wp_kses_post($heading_text);

                if (!empty($settings['link']['url'])) {
                    printf('</a>');
                }
                ?>

            </<?php echo esc_attr(eead_check_allowed_html_tags($settings['heading_html_tag'])); ?>>
            <?php
        }
    }

}
