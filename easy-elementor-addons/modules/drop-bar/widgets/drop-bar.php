<?php

namespace EasyElementorAddons\Modules\DropBar\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Drop Bar Widget
 */
class DropBar extends Widget_Base {

    public function get_name() {
        return 'eead-drop-bar';
    }

    public function get_title() {
        return esc_html__('Drop Bar', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-drop-box';
    }

    public function get_keywords() {
        return ['dropbar', 'dropdown', 'popup'];
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['uikit'];
    }

    public function get_style_depends() {
        return ['uikit'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content_dropbar', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'source', [
                'label' => esc_html__('Select Source', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => esc_html__('Custom Content', 'easy-elementor-addons'),
                    "elementor" => esc_html__('Elementor Template', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__('Dropbar content goes here', 'easy-elementor-addons'),
                'show_label' => false,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam',
                'condition' => ['source' => 'custom']
            ]
        );

        $this->add_control(
            'template_id', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => get_elementor_templates(),
                'label_block' => 'true',
                'condition' => ['source' => "elementor"]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Open Dropbar', 'easy-elementor-addons')
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
            'button_icon_align', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => esc_html__('Before', 'easy-elementor-addons'),
                    'row' => esc_html__('After', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'flex-direction: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_icon_gap', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_align', [
                'label' => esc_html__('Button Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => ' eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Stretch', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-justify',
                    ]
                ],
                'prefix_class' => 'elementor%s-align-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_option', [
                'label' => esc_html__('Dropbar', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'drop_position', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom-left',
                'options' => eead_drop_position()
            ]
        );

        $this->add_control(
            'drop_mode', [
                'label' => esc_html__('Mode', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'click' => esc_html__('Click', 'easy-elementor-addons'),
                    'hover' => esc_html__('Hover', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_responsive_control(
            'drop_width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-drop' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'drop_position!' => ['top-justify', 'bottom-justify'],
                ]
            ]
        );

        $this->add_control(
            'drop_offset', [
                'label' => esc_html__('Dropbar Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                        'step' => 5,
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'animation_option', [
                'label' => esc_html__('Animation', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'drop_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => eead_transition_options()
            ]
        );

        $this->add_control(
            'drop_duration', [
                'label' => esc_html__('Animation Duration', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 200,
                ],
                'range' => [
                    'px' => [
                        'max' => 4000,
                        'step' => 50,
                    ]
                ],
                'condition' => [
                    'drop_animation!' => '',
                ]
            ]
        );

        $this->add_control(
            'drop_show_delay', [
                'label' => esc_html__('Show Delay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'max' => 1000,
                        'step' => 100,
                    ],
                ]
            ]
        );

        $this->add_control(
            'drop_hide_delay', [
                'label' => esc_html__('Hide Delay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'max' => 10000,
                        'step' => 100,
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button', [
                'label' => esc_html__('Button', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
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
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
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
                'selector' => '{{WRAPPER}} .eead-dropbar .eead-dropbar-button'
            ]
        );

        $this->add_responsive_control(
            'button_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'button_text_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .eead-dropbar .eead-dropbar-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-dropbar .eead-dropbar-button'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_hover_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_hover_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_hover_border_color', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dropbar .eead-dropbar-button:hover' => 'border-color: {{VALUE}};',
                ]
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

        $this->start_controls_section(
            'section_style_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_text_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-drop-content' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'content_background', [
                'label' => esc_html__('Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-drop-content' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-drop-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-drop-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .eead-drop-content'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'content_box_text_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-drop-content'
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = 'eead-drop-' . $this->get_id();
        $btn_settings = wp_json_encode([
            "mode" => $settings["drop_mode"],
            "pos" => $settings["drop_position"],
            "delay-hide" => $settings["drop_hide_delay"]["size"],
            "delay-show" => $settings["drop_show_delay"]["size"],
            "offset" => $settings["drop_offset"]["size"],
            "animation" => $settings["drop_animation"] ? "uk-animation-" . $settings["drop_animation"] : false,
            "duration" => ($settings["drop_duration"]["size"] && $settings["drop_animation"]) ? $settings["drop_duration"]["size"] : "0"
        ]);

        $this->add_render_attribute(
            [
                'drop-settings' => [
                    'id' => esc_attr($id),
                    'class' => 'eead-drop uk-drop',
                    'uk-drop' => [$btn_settings],
                ]
            ]
        );
        ?>
        <div class="eead-dropbar">
            <?php $this->get_button(); ?>

            <div <?php $this->print_render_attribute_string('drop-settings'); ?>>
                <div class="eead-drop-content uk-card uk-card-body uk-card-default uk-text-left">
                    <?php
                    if ($settings['source'] == "custom" && !empty($settings['content'])) {
                        echo wp_kses_post($settings['content']);
                    } else if ($settings['source'] == "elementor" && !empty($settings['template_id'])) {
                        echo Plugin::$instance->frontend->get_builder_content_for_display($settings['template_id']);
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function get_button() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('button', [
            'class' => 'eead-dropbar-button',
            'href' => 'javascript:void(0)'
        ]);

        if ($settings['hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . esc_attr($settings['hover_animation']));
        }
        ?>
        <a <?php $this->print_render_attribute_string('button'); ?>>

            <?php echo wp_kses($settings['button_text'], eead_allow_tags('title')); ?>

            <?php
            if (!empty($settings['button_icon']['value'])) {
                ?>
                <span>
                    <?php
                    Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                    ?>
                </span>
                <?php
            }
            ?>
        </a>
        <?php
    }

}
