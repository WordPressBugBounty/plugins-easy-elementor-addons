<?php

namespace EasyElementorAddons\Modules\Switcher\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Switcher extends Widget_Base {

    public function get_name() {
        return 'eead-switcher';
    }

    public function get_title() {
        return esc_html__('Content Switcher', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-switcher';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Tab Title'
            ]
        );

        $repeater->add_control(
            'content_type', [
                'label' => esc_html__('Content Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'wisiwyg',
                'options' => [
                    'wisiwyg' => esc_html__('WISIWYG', 'easy-elementor-addons'),
                    'elementor_template' => esc_html__('Elementor Template', 'easy-elementor-addons'),
                    'page' => esc_html__('Page', 'easy-elementor-addons'),
                ]
            ]
        );

        $repeater->add_control(
            'page', [
                'label' => esc_html__('Select Page', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'multiple' => false,
                'options' => $this->get_pages(),
                'condition' => ['content_type' => 'page']
            ]
        );

        $repeater->add_control(
            'wisiwyg_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'condition' => ['content_type' => 'wisiwyg']
            ]
        );

        $repeater->add_control(
            'elementor_template', [
                'label' => esc_html__('Select Template', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_elementor_templates(),
                'label_block' => 'true',
                'condition' => ['content_type' => 'elementor_template']
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'icofont-star',
                    'library' => 'iconfont'
                ],
            ]
        );

        $this->add_control(
            'switcher', [
                'label' => esc_html__('Lists', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Switch 1',
                        'wisiwyg_content' => 'Ut posuere bibendum pretium. Nulla sit amet felis sem. Donec eu elit efficitur, vehicula quam sit amet, sodales elit. Praesent ac velit arcu. Sed volutpat vitae nulla sed fermentum. Praesent at pulvinar diam, a iaculis justo. In ullamcorper nec risus sit amet malesuada. Sed tempor, risus sit amet vestibulum dignissim, purus magna venenatis velit, sed facilisis diam arcu at leo. Donec nec lacus in ligula pretium finibus a lobortis ipsum. Nullam eu sem quis magna aliquet cursus. Nam vitae faucibus lorem. Praesent maximus, magna et volutpat scelerisque, neque quam hendrerit ante, nec eleifend est nunc a orci.'
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Switch 2',
                        'wisiwyg_content' => 'Aenean facilisis accumsan nunc, vel maximus ipsum dictum ut. Sed in mauris commodo magna faucibus accumsan. Nunc non purus mi. Phasellus aliquet facilisis orci. Nullam vel tempor est. Aliquam eu elit sit amet nunc ullamcorper imperdiet. Phasellus porta egestas dolor sodales porttitor. Nunc mollis purus id nibh tempus pulvinar. In egestas et magna eu aliquam. Nunc dapibus massa metus, tempor lobortis risus cursus vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed dignissim rutrum tortor, vitae viverra augue tincidunt at. Sed leo nisl, congue ut justo in.'
                    ],
                    [
                        'icon' => [
                            'value' => 'icofont-star',
                        ],
                        'title' => 'Switch 3',
                        'wisiwyg_content' => 'Donec justo eros, luctus quis scelerisque id, ultricies sit amet odio. Vestibulum aliquam efficitur eleifend. Praesent dignissim faucibus ex vel sodales. Morbi aliquet libero at augue pharetra vehicula. Cras dapibus lorem efficitur nunc euismod convallis. Nunc molestie risus id lacinia consequat. Integer iaculis orci in ipsum vestibulum, non mattis justo ornare. Cras et lorem tempor ligula suscipit mollis. Nulla vitae augue non leo tempus finibus.'
                    ]
                ],
                'title_field' => '{{{title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'active_switch', [
                'label' => esc_html__('Active Switch', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('First Tab', 'easy-elementor-addons'),
                    '2' => esc_html__('Second Tab', 'easy-elementor-addons'),
                    '3' => esc_html__('Third Tab', 'easy-elementor-addons'),
                    '4' => esc_html__('Fourth Tab', 'easy-elementor-addons'),
                    '5' => esc_html__('Fifth Tab', 'easy-elementor-addons'),
                    '6' => esc_html__('Sixth Tab', 'easy-elementor-addons'),
                    '7' => esc_html__('Seventh Tab', 'easy-elementor-addons'),
                    '8' => esc_html__('Eight Tab', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'content_animation', [
                'label' => esc_html__('Content Display Animation', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => eead_show_animations_alt()
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'switch_custom_style', [
                'label' => esc_html__('Switch Bar', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'switch_alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ),
                ),
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs' => 'align-self: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'switch_spacing', [
                'label' => esc_html__('Spacing Between Buttons', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs-inner' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'switch_bottom_spacing', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => '30',
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'switch_bar_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'switch_bar_border',
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
                'selector' => '{{WRAPPER}} .eead-switcher-tabs'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'switch_bar_shadow',
                'selector' => '{{WRAPPER}} .eead-switcher-tabs'
            ]
        );

        $this->add_responsive_control(
            'switch_bar_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'switch_bar_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tabs' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'switch_buttons_style', [
                'label' => esc_html__('Switch Buttons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'switch_button_typography',
                'selector' => '{{WRAPPER}} .eead-switcher-tab',
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ),
                    'top' => array(
                        'title' => esc_html__('Top', 'easy-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ),
                    'right' => array(
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ),
                ),
                'selectors_dictionary' => [
                    'left' => 'flex-direction:row',
                    'right' => 'flex-direction:row-reverse',
                    'top' => 'flex-direction:column',
                ],
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab' => '{{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-switcher-tab svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'switch_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'switch_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-container' => '--eead-switcher-tab-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs(
            'switch_tabs'
        );

        $this->start_controls_tab(
            'switch_style_normal_tab', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'switch_normal_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-switcher-tab svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'switch_style_hover_tab', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'switch_hover_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-switcher-tab:hover svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'switch_style_active_tab', [
                'label' => esc_html__('Active', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'switch_active_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-container' => '--eead-switcher-tab-active-bg-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'switch_active_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-tab.eead-switcher-active-tab' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-switcher-tab.eead-switcher-active-tab svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'switch_content_custom_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'switch_content_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-contents' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'switch_content_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-contents' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'switch_content_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'switch_content_border',
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
                'selector' => '{{WRAPPER}} .eead-switcher-contents'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'switch_content_shadow',
                'selector' => '{{WRAPPER}} .eead-switcher-contents'
            ]
        );

        $this->add_responsive_control(
            'switch_content_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-switcher-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'switch_content_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-switcher-content'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-switcher-container">
            <div class="eead-switcher-tabs">
                <div class="eead-switcher-tabs-inner">
                    <?php $this->get_tabs(); ?>
                    <span class="eead-switcher-slider"></span>
                </div>
            </div>

            <div class="eead-switcher-contents">
                <?php $this->get_tab_content(); ?>
            </div>
        </div>
        <?php
    }

    private function get_tabs() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['switcher'])) {
            $i = 0;
            $active_switch = count($settings['switcher']) >= $settings['active_switch'] ? $settings['active_switch'] : 1;
            foreach ($settings['switcher'] as $tab) {
                $i++;
                ?>
                <div class="eead-switcher-tab <?php echo ($i == $active_switch ? 'eead-switcher-active-tab' : ''); ?>" data-switchid="<?php echo esc_attr($i); ?>">
                    <?php Icons_Manager::render_icon($tab['icon'], ['aria-hidden' => 'true']); ?>
                    <span><?php echo esc_html($tab['title']); ?></span>
                </div>
                <?php
            }
        }
    }

    private function get_tab_content() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['switcher'])) {
            $i = 0;
            $active_switch = count($settings['switcher']) >= $settings['active_switch'] ? $settings['active_switch'] : 1;
            foreach ($settings['switcher'] as $tab) {
                $i++;
                ?>
                <div class="animated animated-fast <?php echo esc_attr($settings['content_animation']); ?> eead-switcher-content eead-switcher-content-<?php echo esc_attr($i) . ' ' . ($i == $active_switch ? 'eead-switcher-active-content' : ''); ?>">
                    <?php
                    if ($tab['content_type'] == 'page' && !empty($tab['page'])) {
                        $page_id = $tab['page'];
                        $elementor = get_post_meta($page_id, '_elementor_edit_mode', true);
                        if ($elementor) {
                            echo $this->elementor()->frontend->get_builder_content_for_display($page_id);
                        } else {
                            if (!is_wp_error($page_id)) {
                                $content = $page_id->post_content;
                            }
                            echo apply_filters('the_content', $content);
                        }
                    } elseif ($tab['content_type'] == 'elementor_template') {
                        echo $this->elementor()->frontend->get_builder_content_for_display($tab['elementor_template']);
                    } elseif ($tab['content_type'] == 'wisiwyg' and $tab['wisiwyg_content']) {
                        echo wp_kses_post(parse_wisiwyg_content($tab['wisiwyg_content']));
                    }
                    ?>
                </div>
                <?php
            }
        }
    }

    protected function get_elementor_templates() {
        $templates = $this->elementor()->templates_manager->get_source('local')->get_items();
        $types = array();

        if (empty($templates)) {
            $template_options = ['0' => esc_html__('Template Not Found!', 'easy-elementor-addons')];
        } else {
            $template_options = ['0' => esc_html__('Select Template', 'easy-elementor-addons')];

            foreach ($templates as $template) {
                $template_options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
                $types[$template['template_id']] = $template['type'];
            }
        }

        return $template_options;
    }

    protected function elementor() {
        return Plugin::$instance;
    }

    protected function get_pages() {
        $pages = get_pages();

        $_pages = [];
        foreach ($pages as $key => $object) {
            $_pages[$object->ID] = ucfirst($object->post_title);
        }

        return $_pages;
    }

}
