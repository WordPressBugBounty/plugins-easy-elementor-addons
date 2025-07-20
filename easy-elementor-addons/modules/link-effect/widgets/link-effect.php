<?php

namespace EasyElementorAddons\Modules\LinkEffect\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class LinkEffect extends Widget_Base {

    public function get_name() {
        return 'eead-link-effect';
    }

    public function get_title() {
        return esc_html__('Link Effect', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-link';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_link_effects', [
                'label' => esc_html__('Link Effects', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Click Here', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'secondary_text', [
                'label' => esc_html__('Secondary Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Click Here', 'easy-elementor-addons'),
                'condition' => [
                    'effect' => 'effect-9',
                ]
            ]
        );

        $this->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => 'https://www.your-link.com',
                'default' => [
                    'url' => '#',
                ]
            ]
        );

        $this->add_control(
            'effect', [
                'label' => esc_html__('Animation Effect', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'effect-1' => esc_html__('Border Slide In', 'easy-elementor-addons'),
                    'effect-2' => esc_html__('Border Slide Out', 'easy-elementor-addons'),
                    'effect-3' => esc_html__('Brackets', 'easy-elementor-addons'),
                    'effect-4' => esc_html__('3D Cube', 'easy-elementor-addons'),
                    'effect-5' => esc_html__('Duplicate Text Slide In', 'easy-elementor-addons'),
                    'effect-6' => esc_html__('Right Angle Slides Down', 'easy-elementor-addons'),
                    'effect-7' => esc_html__('Second Border Slides Up', 'easy-elementor-addons'),
                    'effect-8' => esc_html__('Border Translate', 'easy-elementor-addons'),
                    'effect-9' => esc_html__('Second Text and Borders', 'easy-elementor-addons'),
                    'effect-10' => esc_html__('Slide Right', 'easy-elementor-addons'),
                    'effect-11' => esc_html__('Text Fill', 'easy-elementor-addons'),
                    'effect-12' => esc_html__('Circle', 'easy-elementor-addons'),
                    'effect-13' => esc_html__('Three Dots', 'easy-elementor-addons'),
                    'effect-14' => esc_html__('Border Switch', 'easy-elementor-addons'),
                    'effect-15' => esc_html__('Scale Down', 'easy-elementor-addons'),
                    'effect-16' => esc_html__('Fall Down', 'easy-elementor-addons'),
                    'effect-17' => esc_html__('Move Up and Push Border', 'easy-elementor-addons'),
                    'effect-18' => esc_html__('Cross Text', 'easy-elementor-addons'),
                    'effect-19' => esc_html__('3D Cube Horizontal Side', 'easy-elementor-addons'),
                    'effect-20' => esc_html__('Flip Unfold', 'easy-elementor-addons'),
                    'effect-21' => esc_html__('Dual Borders Translate', 'easy-elementor-addons'),
                ],
                'default' => 'effect-1'
            ]
        );

        $this->add_responsive_control(
            'button_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 200,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-link-effect-19' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .eead-link-effect-19 span' => 'transform-origin: 50% 50% calc(-{{SIZE}}{{UNIT}}/2)',
                ],
                'condition' => [
                    'effect' => 'effect-19',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style', [
                'label' => esc_html__('Link Effects', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
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
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-justify',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'border_thickness', [
                'label' => esc_html__('Border Thickness', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-border-thickness:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'effect' => ['effect-1', 'effect-2', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-11', 'effect-13', 'effect-14', 'effect-17', 'effect-18', 'effect-21'],
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding_alt', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'allowed_dimensions' => 'vertical',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-button-padding-alt: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;',
                ],
                'condition' => [
                    'effect' => ['effect-1', 'effect-2', 'effect-11', 'effect-13', 'effect-17', 'effect-18', 'effect-21'],
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-button-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'effect' => ['effect-4', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-10', 'effect-14', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} a.eead-link'
            ]
        );

        $this->start_controls_tabs('tabs_link_style');

        $this->start_controls_tab(
            'tab_link_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'link_color_normal', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-color: {{VALUE}};',
                ],
                'condition' => [
                    'effect!' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'link_color_normal_alt', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-color-alt: {{VALUE}};',
                ],
                'condition' => [
                    'effect' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'background_color_normal', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2195de',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-bg-color: {{VALUE}};',
                ],
                'condition' => [
                    'effect' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'link_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-border-color: {{VALUE}};',
                ],
                'condition' => [
                    'effect' => ['effect-1', 'effect-2', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-11', 'effect-12', 'effect-14', 'effect-17', 'effect-18', 'effect-21'],
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_link_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'link_color_hover', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2195de',
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-color-hover: {{VALUE}};',
                ],
                'condition' => [
                    'effect!' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'link_color_hover_alt', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-color-alt-hover: {{VALUE}};',
                ],
                'condition' => [
                    'effect' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'background_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-bg-color-hover: {{VALUE}};'
                ],
                'condition' => [
                    'effect' => ['effect-4', 'effect-10', 'effect-19', 'effect-20'],
                ]
            ]
        );

        $this->add_control(
            'link_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-link-effect-border-color-hover: {{VALUE}};'
                ],
                'condition' => [
                    'effect' => ['effect-1', 'effect-2', 'effect-6', 'effect-7', 'effect-8', 'effect-9', 'effect-11', 'effect-12', 'effect-14', 'effect-17', 'effect-18', 'effect-21'],
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $link = $settings['link']['url'] ? $settings['link']['url'] : '#';
        $link_text = !empty($settings['text']) ? $settings['text'] : '';
        $link_secondary_text = !empty($settings['secondary_text']) ? $settings['secondary_text'] : '';

        $effect_one = ['effect-4', 'effect-5', 'effect-19', 'effect-20'];
        $effect_two = ['effect-10', 'effect-11', 'effect-15', 'effect-16', 'effect-17', 'effect-18'];

        if (in_array($settings['effect'], $effect_one)) {
            $this->add_render_attribute('eead-link-text', 'data-hover', esc_html($link_text));
        } else if (in_array($settings['effect'], $effect_two)) {
            $this->add_render_attribute('eead-link-text-2', 'data-hover', esc_html($link_text));
        }
        ?>
        <a href="<?php echo esc_url($link); ?>" class="eead-link eead-link-<?php echo esc_attr($settings['effect']); ?>" <?php echo $this->get_render_attribute_string('eead-link-text-2'); ?>>
            <span <?php echo $this->get_render_attribute_string('eead-link-text'); ?>>
                <?php echo esc_html($link_text); ?>
            </span>

            <?php if ($settings['effect'] === 'effect-9') { ?>
                <span>
                    <?php echo esc_html($link_secondary_text); ?>
                </span>
            <?php } ?>
        </a>
        <?php
    }

}
