<?php

namespace EasyElementorAddons\Modules\AdvancedButton\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Button Widget
 */
class AdvancedButton extends Widget_Base {

    public function get_name() {
        return 'eead-advanced-button';
    }

    public function get_title() {
        return esc_html__('Advanced Button', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-button';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return [];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Click me', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Click me', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ]
            ]
        );

        $this->add_control(
            'button_size', [
                'label' => esc_html__('Button Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'md',
                'label_block' => true,
                'options' => [
                    'xs' => esc_html__('Extra Small', 'easy-elementor-addons'),
                    'sm' => esc_html__('Small', 'easy-elementor-addons'),
                    'md' => esc_html__('Medium', 'easy-elementor-addons'),
                    'lg' => esc_html__('Large', 'easy-elementor-addons'),
                    'xl' => esc_html__('Extra Large', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-ab-button-size-'
            ]
        );

        $this->add_control(
            'button_animation', [
                'label' => esc_html__('Background Animation (Hover)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'b',
                'options' => [
                    'a' => esc_html__('Fade In', 'easy-elementor-addons'),
                    'b' => esc_html__('Slide Down', 'easy-elementor-addons'),
                    'c' => esc_html__('Slide Right', 'easy-elementor-addons'),
                    'd' => esc_html__('Horizontal Center In', 'easy-elementor-addons'),
                    'e' => esc_html__('Center In Skew', 'easy-elementor-addons'),
                    'f' => esc_html__('Vertical Center In', 'easy-elementor-addons'),
                    'g' => esc_html__('Move Text', 'easy-elementor-addons'),
                    'h' => esc_html__('Inclined Slide Down', 'easy-elementor-addons'),
                    'i' => esc_html__('Horizontal Center Out', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-ab-button-effect-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'easy-elementor-addons'),
                    'right' => esc_html__('Right', 'easy-elementor-addons'),
                    'top' => esc_html__('Top', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Bottom', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'prefix_class' => 'eead-ab-icon-align-'
            ]
        );

        $this->add_control(
            'icon_indent', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 8,
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-ab-button-icon-spacing: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-ab-button'
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'easy-elementor-addons'),
                        'icon' => 'eicon-grow',
                    ]
                ],
                'prefix_class' => 'eead-ab-button-align-'
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ab-button' => '--eead-ab-button-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ab-button' => '--eead-ab-button-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-ab-button-text-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-ab-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
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
                'selector' => '{{WRAPPER}} .eead-ab-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .eead-ab-button'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-ab-button-text-color-hover: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'button_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#444444',
                    ]
                ],
                'selector' => '{{WRAPPER}} .eead-ab-button:after,
                {{WRAPPER}} .eead-ab-button::before'
            ]
        );

        $this->add_control(
            'button_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ab-button:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .eead-ab-button:hover'
            ]
        );

        $this->add_control(
            'hover_animation', [
                'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'eead-ab-button-wrapper');

        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('button', $settings['link']);
        }

        $this->add_render_attribute('button', 'class', 'eead-ab-button');

        if ($settings['hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <a <?php $this->print_render_attribute_string('button'); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php
    }

    public function render_text() {

        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('content-wrapper', 'class', 'eead-ab-button-content-wrapper');
        $this->add_render_attribute('text', 'class', 'eead-ab-button-text');
        $this->add_inline_editing_attributes('text', 'none');
        ?>
        <div <?php $this->print_render_attribute_string('content-wrapper'); ?>>
            <?php
            if (!empty($settings['button_icon']['value'])) {
                ?>
                <div class="eead-ab-button-icon">
                    <?php
                    Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                    ?>
                </div>
                <?php
            }
            ?>

            <div <?php $this->print_render_attribute_string('text'); ?>>
                <span class="eead-ab-button-span-text">
                    <?php echo esc_html($settings['text']); ?>
                </span>
            </div>
        </div>
        <?php
    }

}
