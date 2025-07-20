<?php

namespace EasyElementorAddons\Modules\Lottie\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Lottie extends Widget_Base {

    public function get_script_depends() {
        return ['lottie'];
    }

    public function get_name() {
        return 'eead-lottie';
    }

    public function get_title() {
        return esc_html__('Lottie', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-lottie';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'lottie', [
                'label' => esc_html__('Lottie', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lottie_type', [
                'label' => esc_html__('Select JSON', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'url',
                'options' => [
                    'file' => [
                        'title' => esc_html__('JSON File', 'easy-elementor-addons'),
                        'icon' => 'eicon-document-file',
                    ],
                    'url' => [
                        'title' => esc_html__('JSON URL', 'easy-elementor-addons'),
                        'icon' => 'eicon-link',
                    ]
                ]
            ]
        );

        $this->add_control(
            'lottie_json', [
                'show_label' => false,
                'description' => sprintf(
                    esc_html__('Discover thousands of %sLottie animations%s ready to use.', 'easy-elementor-addons'), '<a href="https://lottiefiles.com/featured" target="_blank">', '</a>'
                ),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'application/json',
                'condition' => [
                    'lottie_type' => 'file'
                ],
            ]
        );

        $this->add_control(
            'lottie_url', [
                'show_label' => false,
                'label_block' => true,
                'description' => sprintf(
                    esc_html__('Discover thousands of %sLottie animations%s ready to use.', 'easy-elementor-addons'), '<a href="https://lottiefiles.com/featured" target="_blank">', '</a>'
                ),
                'default' => 'https://assets6.lottiefiles.com/packages/lf20_sgnacf85.json',
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://example.com/file.json',
                'show_external' => false,
                'condition' => [
                    'lottie_type' => 'url'
                ],
            ]
        );

        $this->add_control(
            'lottie_link_check', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'lottie_link', [
                'show_label' => false,
                'type' => Controls_Manager::URL,
                'condition' => [
                    'lottie_link_check' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        /* Animation Options */
        $this->start_controls_section(
            'lottie_animation_options', [
                'label' => esc_html__('Animations', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lottie_autoplay', [
                'label' => esc_html__('Autoplay', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'lottie_reverse', [
                'label' => esc_html__('Reverse', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'lottie_speed', [
                'label' => esc_html__('Speed', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'size' => 1
                ],
            ]
        );

        $this->add_control(
            'lottie_render_type', [
                'label' => esc_html__('Render Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'svg',
                'toggle' => false,
                'options' => [
                    'svg' => [
                        'title' => esc_html__('SVG', 'easy-elementor-addons'),
                        'icon' => 'eicon-ai',
                    ],
                    'canvas' => [
                        'title' => esc_html__('Canvas', 'easy-elementor-addons'),
                        'icon' => 'eicon-tv',
                    ]
                ],
            ]
        );

        $this->add_control(
            'lottie_action', [
                'label' => esc_html__('On Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'easy-elementor-addons'),
                    'pause' => esc_html__('Pause', 'easy-elementor-addons'),
                    'reverse' => esc_html__('Reverse', 'easy-elementor-addons')
                ],
                'condition' => [
                    'lottie_autoplay' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'lottie_action_alt', [
                'label' => esc_html__('On Hover', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'easy-elementor-addons'),
                    'play' => esc_html__('Play', 'easy-elementor-addons')
                ],
                'condition' => [
                    'lottie_autoplay!' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // Lottie Style Settings
        $this->start_controls_section(
            'lottie_styles', [
                'label' => esc_html__('Lottie', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'lottie_state'
        );

        $this->start_controls_tab(
            'lottie_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'lottie_opacity', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-lottie' => 'opacity: {{SIZE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(), [
                'name' => 'lottie_filter',
                'selector' => '{{WRAPPER}} .eead-lottie',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lottie_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'lottie_opacity_hover', [
                'label' => esc_html__('Opacity', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-lottie:hover' => 'opacity: {{SIZE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(), [
                'name' => 'lottie_filter_hover',
                'selector' => '{{WRAPPER}} .eead-lottie:hover',
            ]
        );

        $this->add_control(
            'lottie_transition', [
                'label' => esc_html__('Transition Duration(Seconds)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'size' => '0.3'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-lottie' => 'transition: all {{SIZE}}s ease;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="eead-lottie-container">
            <?php
            $tag = 'div';

            $lottie_settings = array(
                'renderer' => $settings['lottie_render_type'],
                'autoplay' => $settings['lottie_autoplay'] ? true : false,
                'reverse' => $settings['lottie_reverse'] ? '-1' : '1',
                'speed' => isset($settings['lottie_speed']['size']) ? $settings['lottie_speed']['size'] : 1,
                'action' => $settings['lottie_action'],
                'action_alt' => $settings['lottie_action_alt'],
            );

            if (!empty($settings['lottie_json']['url'])) {
                $lottie_settings['path'] = $settings['lottie_json']['url'];
            } else {
                $lottie_settings['path'] = $settings['lottie_url'];
            }

            $this->add_render_attribute('wrapper', [
                'id' => esc_attr('eead-lottie-' . $this->get_id()),
                'class' => 'eead-lottie',
                'data-settings' => json_encode($lottie_settings)
            ]);

            if ($settings['lottie_link_check']) {
                $tag = 'a';

                if (!empty($settings['lottie_link']['url'])) {
                    $this->add_link_attributes('link', $settings['lottie_link']);
                }
            }

            echo '<' . $tag . ' ' . $this->get_render_attribute_string('wrapper') . ' ' . $this->get_render_attribute_string('link') . '>&nbsp</' . $tag . '>';
            ?>
        </div>
        <?php
    }

}
