<?php

namespace EasyElementorAddons\Modules\IconList\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class IconList extends Widget_Base {

    public function get_name() {
        return 'eead-icon-list';
    }

    public function get_title() {
        return esc_html__('Icon List', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-icon-list';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_list', [
                'label' => esc_html__('List', 'easy-elementor-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('List Item #1', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'icon_type', [
                'label' => esc_html__('Icon Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => array(
                    'none' => array(
                        'title' => esc_html__('None', 'easy-elementor-addons'),
                        'icon' => 'eicon-close',
                    ),
                    'icon' => array(
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ),
                    'image' => array(
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ),
                    'number' => array(
                        'title' => esc_html__('Number', 'easy-elementor-addons'),
                        'icon' => 'eicon-number-field',
                    ),
                ),
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => array(
                    'value' => 'icofont-check-alt',
                    'library' => 'icofont'
                ),
                'condition' => array(
                    'icon_type' => 'icon',
                ),
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'label_block' => true,
                'type' => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
                'condition' => array(
                    'icon_type' => 'image',
                ),
            ]
        );

        $repeater->add_control(
            'num_text', [
                'label' => esc_html__('Number/Text', 'easy-elementor-addons'),
                'label_block' => false,
                'type' => Controls_Manager::TEXT,
                'condition' => array(
                    'icon_type' => 'number',
                ),
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => 'http://your-link.com',
            ]
        );

        $this->add_control(
            'list_items', [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => array(
                    array(
                        'text' => esc_html__('List Item #1', 'easy-elementor-addons'),
                        'icon' => 'icofont-check-alt',
                    ),
                    array(
                        'text' => esc_html__('List Item #2', 'easy-elementor-addons'),
                        'icon' => 'icofont-check-alt',
                    ),
                    array(
                        'text' => esc_html__('List Item #3', 'easy-elementor-addons'),
                        'icon' => 'icofont-check-alt',
                    ),
                ),
                'fields' => $repeater->get_controls(),
                'title_field' => '<i class="{{icon}}" aria-hidden="true"></i> {{{text}}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_list_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'list_view', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'inline' => esc_html__('Inline', 'easy-elementor-addons'),
                    'grid' => esc_html__('Grid', 'easy-elementor-addons')
                ],
                'prefix_class' => 'eead-icon-list-',
            ]
        );

        $this->add_responsive_control(
            'list_column', [
                'label' => esc_html__('Grid Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => esc_html__('1', 'easy-elementor-addons'),
                    '2' => esc_html__('2', 'easy-elementor-addons'),
                    '3' => esc_html__('3', 'easy-elementor-addons'),
                    '4' => esc_html__('4', 'easy-elementor-addons'),
                    '5' => esc_html__('5', 'easy-elementor-addons'),
                    '6' => esc_html__('6', 'easy-elementor-addons'),
                    '7' => esc_html__('7', 'easy-elementor-addons'),
                    '8' => esc_html__('8', 'easy-elementor-addons')
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items' => 'grid-template-columns: repeat({{SIZE}}, 1fr);'
                ],
                'prefix_class' => 'eead-lc%s-col-',
                'render_type' => 'template',
                'condition' => ['list_view' => 'grid']
            ]
        );

        $this->add_responsive_control(
            'list_alignment', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'flex-start',
                'selectors_dictionary' => [
                    'flex-start' => 'text-align:left; justify-content:flex-start;',
                    'flex-end' => 'text-align:right; justify-content:flex-end;'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items li .eead-il-block' => '{{VALUE}};'
                ],
                'condition' => ['list_view!' => 'inline']
            ]
        );

        $this->add_responsive_control(
            'list_inline_alignment', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items' => 'justify-content: {{VALUE}};'
                ],
                'condition' => ['list_view' => 'inline']
            ]
        );

        $this->add_responsive_control(
            'v_list_spacing', [
                'label' => esc_html__('Vertical List Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items' => 'row-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}:where(.eead-icon-list-default, .eead-icon-list-grid) .eead-icon-list-items li:after' => 'margin-top: calc({{SIZE}}{{UNIT}}/2);'
                ],
            ]
        );

        $this->add_responsive_control(
            'h_list_spacing', [
                'label' => esc_html__('Horizontal List Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items' => 'column-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.eead-icon-list-inline .eead-icon-list-items li:after' => 'margin-left: calc({{SIZE}}{{UNIT}}/2);'
                ],
                'condition' => ['list_view!' => 'default']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_list_style', [
                'label' => esc_html__('List', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'item_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-icon-list-items li .eead-il-block',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'item_border',
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
                'selector' => '{{WRAPPER}} .eead-icon-list-items li .eead-il-block',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'item_boxshadow',
                'selector' => '{{WRAPPER}} .eead-icon-list-items li .eead-il-block',
            ]
        );

        $this->add_responsive_control(
            'item_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items li .eead-il-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'item_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items li .eead-il-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'item_divider', [
                'label' => esc_html__('Divider', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'easy-elementor-addons'),
                'label_on' => esc_html__('On', 'easy-elementor-addons'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_divider_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'easy-elementor-addons'),
                    'double' => esc_html__('Double', 'easy-elementor-addons'),
                    'dotted' => esc_html__('Dotted', 'easy-elementor-addons'),
                    'dashed' => esc_html__('Dashed', 'easy-elementor-addons'),
                    'groove' => esc_html__('Groove', 'easy-elementor-addons'),
                    'ridge' => esc_html__('Ridge', 'easy-elementor-addons')
                ],
                'default' => 'solid',
                'condition' => [
                    'item_divider' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}}:where(.eead-icon-list-default, .eead-icon-list-grid) .eead-icon-list-items li:after' => 'border-bottom-style: {{VALUE}};',
                    '{{WRAPPER}}.eead-icon-list-inline .eead-icon-list-items li:after' => 'border-right-style: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'item_divider_weight', [
                'label' => esc_html__('Weight', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ]
                ],
                'condition' => [
                    'item_divider' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}}:where(.eead-icon-list-default, .eead-icon-list-grid) .eead-icon-list-items li:after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.eead-icon-list-inline .eead-icon-list-items li:after' => 'border-right-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'item_divider_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
                'condition' => [
                    'item_divider' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}}:where(.eead-icon-list-default, .eead-icon-list-grid) .eead-icon-list-items li:after' => 'border-bottom-color: {{VALUE}};',
                    '{{WRAPPER}}.eead-icon-list-inline .eead-icon-list-items li:after' => 'border-right-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style', [
                'label' => esc_html__('Icon & Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-icon-list-items .eead-il-block',
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-icon img' => 'min-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-icon svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_position', [
                'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'toggle' => false,
                'default' => '0',
                'options' => [
                    '0' => [
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    '2' => [
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items li .eead-il-block .eead-il-icon' => 'order:{{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_vertical_align', [
                'label' => esc_html__('Icon Vertical Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                    '{{WRAPPER}} .eead-icon-list-items li .eead-il-block' => 'align-items: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing', [
                'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-block' => 'gap: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
            'tab_icon_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-block' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-icon-list-items .eead-il-block .eead-il-icon svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_color_hover', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-icon-list-item .eead-il-block:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eead-icon-list-item .eead-il-block:hover .eead-il-icon svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'icon_hover_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $list_column = isset($settings['list_column']) ? (int) $settings['list_column'] : 3;
        $list_column_tablet = isset($settings['list_column_tablet']) ? (int) $settings['list_column_tablet'] : 2;
        $list_column_mobile = isset($settings['list_column_mobile']) ? (int) $settings['list_column_mobile'] : 1;
        ?>
        <div class="eead-icon-list-container">
            <ul class="eead-icon-list-items">
                <?php
                $count = 1;
                if ($settings['list_view'] == 'grid') {
                    $list_items = count($settings['list_items']);
                    $last_row_items = $list_items % $list_column == 0 ? $list_column : $list_items % $list_column;
                    $tablet_last_row_items = $list_items % $list_column_tablet == 0 ? $list_column_tablet : $list_items % $list_column_tablet;
                    $mobile_last_row_items = $list_items % $list_column_mobile == 0 ? $list_column_mobile : $list_items % $list_column_mobile;
                }

                foreach ($settings['list_items'] as $index => $list) {
                    if ($list['text']) {
                        $tag = 'span';

                        $this->add_render_attribute([
                            'items-' . $count => [
                                'class' => [
                                    'eead-il-block',
                                    $settings['icon_hover_animation'] ? 'elementor-animation-' . esc_attr($settings['icon_hover_animation']) : '',
                                ]
                            ]
                        ]);

                        if (isset($list['link']) && !empty($list['link']['url'])) {
                            $this->add_render_attribute([
                                'items-' . $count => [
                                    'href' => esc_url($list['link']['url']),
                                    'target' => $list['link']['is_external'] ? '_blank' : '',
                                    'rel' => $list['link']['nofollow'] ? 'nofollow' : ''
                                ]
                            ]);
                            $tag = 'a';
                        }

                        $classes = [
                            'eead-icon-list-item',
                            'eead-icon-list-item-' . $count,
                            ($settings['list_view'] == 'grid' && $list_items - $count < $last_row_items) ? 'eead-last-row' : '',
                            ($settings['list_view'] == 'grid' && $list_items - $count < $tablet_last_row_items) ? 'eead-tablet-last-row' : '',
                            ($settings['list_view'] == 'grid' && $list_items - $count < $mobile_last_row_items) ? 'eead-mobile-last-row' : '',
                        ];
                        $this->add_render_attribute('list-item' . $count, ['class' => array_filter($classes)]);
                        ?>
                        <li <?php $this->print_render_attribute_string('list-item' . $count); ?>>
                            <<?php echo esc_attr($tag); ?>                 <?php $this->print_render_attribute_string('items-' . $count); ?>>
                                <?php
                                $this->render_list_icon($list, $count);
                                ?>
                                <span class="eead-il-text">
                                    <?php echo wp_kses_post($list['text']); ?>
                                </span>
                            </<?php echo esc_attr($tag); ?>>
                        </li>
                        <?php
                    }
                    $count++;
                }
                ?>
            </ul>
        </div>
        <?php
    }

    protected function render_list_icon($list, $count) {
        echo '<span class="eead-il-icon">';
        switch ($list['icon_type']) {
            case 'icon':
                if (!empty($list['icon']['value'])) {
                    Icons_Manager::render_icon($list['icon'], ['aria-hidden' => 'true']);
                }
                break;

            case 'image':
                echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($list, 'full', 'image'));
                break;

            case 'number':
                $number = $list['num_text'] ? $list['num_text'] : $count;
                echo esc_html($number);
                break;
        }
        echo '</span>';
    }

}
