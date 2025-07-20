<?php

namespace EasyElementorAddons\Modules\OnePageNavigation\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OnePageNavigation extends Widget_Base {

    public function get_name() {
        return 'eead-one-page-nav';
    }

    public function get_title() {
        return esc_html__('One Page Navigation', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-one-page-nav';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_nav_dots', [
                'label' => esc_html__('Navigation Dots', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'select_dot_icon', [
                'label' => esc_html__('Navigation Dot', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icofont-plus-circle',
                    'library' => 'iconfont'
                ]
            ]
        );

        $repeater->add_control(
            'section_title', [
                'label' => esc_html__('Section Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Section Title', 'easy-elementor-addons')
            ]
        );

        $repeater->add_control(
            'section_id', [
                'label' => esc_html__('Section ID', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'nav_dots', [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'section_title' => esc_html__('Section 1', 'easy-elementor-addons'),
                        'section_id' => 'section-1',
                        'select_dot_icon' => 'icofont-plus-circle',
                    ],
                    [
                        'section_title' => esc_html__('Section 2', 'easy-elementor-addons'),
                        'section_id' => 'section-2',
                        'select_dot_icon' => 'icofont-plus-circle',
                    ],
                    [
                        'section_title' => esc_html__('Section 3', 'easy-elementor-addons'),
                        'section_id' => 'section-3',
                        'select_dot_icon' => 'icofont-plus-circle',
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ section_title }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_onepage_nav_settings', [
                'label' => esc_html__('Additional Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'scroll_wheel', [
                'label' => esc_html__('Scroll Wheel', 'easy-elementor-addons'),
                'description' => esc_html__('Scroll the mouse to navigate from one section to another', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'off',
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'return_value' => 'on'
            ]
        );

        $this->add_control(
            'scroll_touch', [
                'label' => esc_html__('Touch Swipe', 'easy-elementor-addons'),
                'description' => esc_html__('Swipe to navigate from one section to another on touch devices', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'off',
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'return_value' => 'on',
                'condition' => [
                    'scroll_wheel' => 'on',
                ]
            ]
        );

        $this->add_control(
            'scroll_keys', [
                'label' => esc_html__('Scroll Keys', 'easy-elementor-addons'),
                'description' => esc_html__('Press UP or DOWN keys to navigate from one section to another', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'off',
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'return_value' => 'on'
            ]
        );

        $this->add_control(
            'scrolling_speed', [
                'label' => esc_html__('Scrolling Speed', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => '700'
            ]
        );

        $this->add_control(
            'offset', [
                'label' => esc_html__('Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '0'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px']
            ]
        );

        $this->add_control(
            'position', [
                'label' => esc_html__('Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left-top' => esc_html__('Left Top', 'easy-elementor-addons'),
                    'left-middle' => esc_html__('Left Middle', 'easy-elementor-addons'),
                    'left-bottom' => esc_html__('Left Bottom', 'easy-elementor-addons'),
                    'right-top' => esc_html__('Right Top', 'easy-elementor-addons'),
                    'right-middle' => esc_html__('Right Middle', 'easy-elementor-addons'),
                    'right-bottom' => esc_html__('Right Bottom', 'easy-elementor-addons'),
                    'center-top' => esc_html__('Center Top', 'easy-elementor-addons'),
                    'center-bottom' => esc_html__('Center Bottom', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-opn-pos-',
                'default' => 'right-middle',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'oritentation', [
                'label' => esc_html__('Orientation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'easy-elementor-addons'),
                    'vertical' => esc_html__('Vertical', 'easy-elementor-addons')
                ],
                'prefix_class' => 'eead-opn-orientation-',
                'default' => 'vertical',
                'condition' => [
                    'position!' => ['left-middle', 'right-middle', 'center-top', 'center-bottom'],
                ]
            ]
        );

        $this->add_responsive_control(
            'top_offset', [
                'label' => esc_html__('Top Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '20'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px', 'em', '%', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-container' => '--eead-opn-offset-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'position' => ['left-top', 'right-top', 'center-top'],
                ]
            ]
        );

        $this->add_responsive_control(
            'bottom_offset', [
                'label' => esc_html__('Bottom Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '20'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px', 'em', '%', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-container' => '--eead-opn-offset-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'position' => ['left-bottom', 'right-bottom', 'center-bottom'],
                ]
            ]
        );

        $this->add_responsive_control(
            'left_offset', [
                'label' => esc_html__('Left Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '20'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px', 'em', '%', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-container' => '--eead-opn-offset-left: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'position' => ['left-top', 'left-middle', 'left-bottom'],
                ]
            ]
        );

        $this->add_responsive_control(
            'right_offset', [
                'label' => esc_html__('Right Offset', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '20'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px', 'em', '%', 'vh'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-container' => '--eead-opn-offset-right: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'position' => ['right-top', 'right-middle', 'right-bottom'],
                ]
            ]
        );

        $this->add_control(
            'nav_tooltip', [
                'label' => esc_html__('Enable Tool Tip', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        /* Style Controls */
        $this->start_controls_section(
            'section_nav_box_style', [
                'label' => esc_html__('Navigation Box', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'nav_container_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .eead-one-page-nav'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'nav_container_border',
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
                'selector' => '{{WRAPPER}} .eead-one-page-nav'
            ]
        );

        $this->add_responsive_control(
            'nav_container_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'nav_container_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'nav_container_box_shadow',
                'selector' => '{{WRAPPER}} .eead-one-page-nav',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_dots_style', [
                'label' => esc_html__('Navigation Dots', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '16'
                ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 60,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-nav-dot svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_size', [
                'label' => esc_html__('Background Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '20'
                ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 60,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '15'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'size_units' => ['px', 'em', 'vh', 'vw'],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'dots_box_shadow',
                'selector' => '{{WRAPPER}} .eead-nav-dot',
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('tabs_dots_style');

        $this->start_controls_tab(
            'tab_dots_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dots_icon_color_normal', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-nav-dot svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dots_color_normal', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'dots_border',
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
                'selector' => '{{WRAPPER}} .eead-nav-dot'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dots_icon_color_hover', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-nav-dot:hover svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dots_color_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dots_border_color_hover', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot:hover' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_active', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'dots_icon_color_active', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-item.active .eead-nav-dot i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-one-page-nav-item.active .eead-nav-dot svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dots_color_active', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-item.active .eead-nav-dot' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'dots_border_color_active', [
                'label' => esc_html__('Border Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-item.active .eead-nav-dot' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tooltips_style', [
                'label' => esc_html__('Tool Tip', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'nav_tooltip' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tooltip_arrow', [
                'label' => esc_html__('Tool Tip Arrow', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Show', 'easy-elementor-addons'),
                'label_off' => esc_html__('Hide', 'easy-elementor-addons'),
                'condition' => [
                    'nav_tooltip' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'distance', [
                'label' => esc_html__('Tool Tip OffSet', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '10',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-one-page-nav-container' => '--eead-opn-tooltip-offset: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'nav_tooltip' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tooltip_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot-tooltip, {{WRAPPER}} .eead-nav-dot-tooltip.eead-tooltip-arrow:after' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tooltip_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot-tooltip' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'nav_tooltip' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'tooltip_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-nav-dot-tooltip',
                'condition' => [
                    'nav_tooltip' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'tooltip_box_shadow',
                'label' => esc_html__('Box Shadow', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-nav-dot-tooltip'
            ]
        );

        $this->add_responsive_control(
            'tooltip_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-nav-dot-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $this->add_render_attribute(
            'onepage-nav', [
                'class' => 'eead-one-page-nav',
                'id' => esc_attr('eead-one-page-nav-' . $this->get_id()),
                'data-section-id' => esc_attr('eead-one-page-nav-' . $this->get_id()),
                'data-top-offset' => esc_attr($settings['offset']['size']),
                'data-scroll-speed' => esc_attr($settings['scrolling_speed']),
                'data-scroll-wheel' => esc_attr($settings['scroll_wheel']),
                'data-scroll-touch' => esc_attr($settings['scroll_touch']),
                'data-scroll-keys' => esc_attr($settings['scroll_keys'])
            ]
        );

        $this->add_render_attribute('tooltip', 'class', 'eead-nav-dot-tooltip');
        if ($settings['tooltip_arrow'] == 'yes') {
            $this->add_render_attribute('tooltip', 'class', 'eead-tooltip-arrow');
        }
        ?>
        <div class='eead-one-page-nav-container'>
            <ul <?php echo wp_kses_post($this->get_render_attribute_string('onepage-nav')); ?>>
                <?php
                $count = 1;
                foreach ($settings['nav_dots'] as $index => $dot) {
                    ?>
                    <li class="eead-one-page-nav-item">
                        <?php
                        if ($settings['nav_tooltip'] == 'yes') {
                            printf('<span %1$s>%2$s</span>', $this->get_render_attribute_string('tooltip'), esc_html($dot['section_title']));
                        }
                        ?>
                        <a href="#" data-row-id="<?php echo esc_attr($dot['section_id']); ?>">
                            <span class="eead-nav-dot">
                                <?php
                                Icons_Manager::render_icon($dot['select_dot_icon'], ['aria-hidden' => 'true']);
                                ?>
                            </span>
                        </a>
                    </li>
                    <?php
                    $count++;
                }
                ?>
            </ul>
        </div>

        <?php if (Plugin::instance()->editor->is_edit_mode()) { ?>
            <div class="eead-editor-placeholder">
                <h4 class="eead-editor-placeholder-title">
                    <?php _e('One Page Navigation', 'easy-elementor-addons'); ?>
                </h4>

                <div class="eead-editor-placeholder-content">
                    <p><?php _e('Click here to edit the Navigation settings. This text will not show in the frontend.', 'easy-elementor-addons'); ?></p>
                </div>
            </div>
            <?php
        }
    }

}
