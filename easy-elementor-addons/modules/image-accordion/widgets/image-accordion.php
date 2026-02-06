<?php

namespace EasyElementorAddons\Modules\ImageAccordion\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class ImageAccordion extends Widget_Base {

    public function get_name() {
        return 'eead-image-accordion';
    }

    public function get_title() {
        return esc_html__('Image Accordion', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-image-accordion';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_keywords() {
        return [
            'image',
            'image accordion',
            'image effect',
            'hover effect',
            'creative image',
            'gallery',
        ];
    }

    protected function register_controls() {
        /**
         * Image accordion Adder
         */
        $this->start_controls_section(
            'image_accordion_section', [
                'label' => esc_html__('Accordion', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image_accordion_bg', [
                'label' => esc_html__('Background Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
            ]
        );

        $repeater->add_control(
            'image_accordion_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Accordion item title', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'image_accordion_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => esc_html__('Accordion content goes here!', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'image_accordion_is_active', [
                'label' => esc_html__('Is Active?', 'easy-elementor-addons'),
                'description' => esc_html__('Enabling it will open this block on page load.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'image_accordion_link_image', [
                'label' => esc_html__('Link Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'image_accordion_link', [
                'name' => 'image_accordion_link',
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => ''
                ],
                'show_external' => true,
                'condition' => [
                    'image_accordion_link_image' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'image_accordions', [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [
                        'image_accordion_title' => esc_html__('Image Accordion #1', 'easy-elementor-addons'),
                        'image_accordion_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing, elit. Ratione, dolore expedita repudiandae unde nihil, accusantium!',
                        'image_accordion_bg' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ],
                    [
                        'image_accordion_title' => esc_html__('Image Accordion #2', 'easy-elementor-addons'),
                        'image_accordion_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing, elit. Ratione, dolore expedita repudiandae unde nihil, accusantium!',
                        'image_accordion_bg' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ],
                    [
                        'image_accordion_title' => esc_html__('Image Accordion #3', 'easy-elementor-addons'),
                        'image_accordion_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing, elit. Ratione, dolore expedita repudiandae unde nihil, accusantium!',
                        'image_accordion_bg' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ]
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{image_accordion_title}}',
            ]
        );

        $this->end_controls_section();

        /**
         * Image accordion General Settings
         */
        $this->start_controls_section(
            'imgage_accordion_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'image_accordion_action_type', [
                'label' => esc_html__('Open Accordion', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'on-hover',
                'label_block' => false,
                'options' => [
                    'on-hover' => esc_html__('On Hover', 'easy-elementor-addons'),
                    'on-click' => esc_html__('On Click', 'easy-elementor-addons')
                ],
            ]
        );

        $this->add_control(
            'image_accordion_orientation', [
                'label' => esc_html__('Accordion Orientation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'easy-elementor-addons'),
                    'vertical' => esc_html__('Vertical', 'easy-elementor-addons')
                ],
                'default' => 'horizontal',
            ]
        );

        $this->add_control(
            'image_accordion_content_horizontal_align', [
                'label' => esc_html__('Content Text Align', 'easy-elementor-addons'),
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
                'selectors_dictionary' => [
                    'left' => 'justify-content: flex-start; text-align: left;',
                    'center' => 'justify-content: center; text-align: center;',
                    'right' => 'justify-content: flex-end; text-align: right;'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion-box' => '{{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'image_accordion_content_vertical_align', [
                'label' => esc_html__('Content Vertical Position', 'easy-elementor-addons'),
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
                'toggle' => false,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion-box' => 'align-items: {{VALUE}};'
                ],
            ]
        );


        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Select Title Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => eead_html_tags(),
            ]
        );

        $this->end_controls_section();

        /**
         * Image Accordion General Style
         */
        $this->start_controls_section(
            'image_accordion_style_settings', [
                'label' => esc_html__('General', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_accordion_height', [
                'label' => esc_html__('Height (px)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion' => 'height: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_control(
            'image_accordion_overlay_color', [
                'label' => esc_html__('Normal Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, .2)',
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item::before' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'image_accordion_overlay_hover_color', [
                'label' => esc_html__('Hover Overlay Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, .5)',
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item:hover::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item.overlay-active::before' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'image_accordion_shadow',
                'selector' => '{{WRAPPER}} .eead-image-accordion',
            ]
        );

        $this->end_controls_section();

        /* Thumbnail Tab Style */
        $this->start_controls_section(
            'section_img_accordion_image_style', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_accordion_image_margin', [
                'label' => esc_html__('Margin', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_accordion_image_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_accordion_image_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'image_accordion_image_border',
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
                'selector' => '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-item',
            ]
        );

        $this->end_controls_section();

        /**
         * Accordion Title Style
         */
        $this->start_controls_section(
            'image_accordion_title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'image_accordion_title_typography',
                'selector' => '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-title',
            ]
        );

        $this->add_control(
            'image_accordion_title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-title' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_accordion_title_margin', [
                'label' => esc_html__('Bottom Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Accordion Content Style
         */
        $this->start_controls_section(
            'image_accordion_content_style', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'image_accordion_content_typography',
                'selector' => '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-text',
            ]
        );

        $this->add_control(
            'image_accordion_content_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-image-accordion .eead-image-accordion-text' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $vertical_align = 'eead-image-accordion-vertical-align-' . (isset($settings['image_accordion_content_vertical_align']) ? $settings['image_accordion_content_vertical_align'] : 'center');
        $horizontal_align = 'eead-image-accordion-horizontal-align-' . (isset($settings['image_accordion_content_horizontal_align']) ? $settings['image_accordion_content_horizontal_align'] : 'center');

        $this->add_render_attribute(
            'eead-image-accordion', [
                'class' => [
                    'eead-image-accordion',
                    'eead-image-accordion-direction-' . esc_attr($settings['image_accordion_orientation']),
                    'eead-image-accordion-' . esc_attr($settings['image_accordion_action_type']),
                    $horizontal_align,
                    $vertical_align
                ],
            ]
        );

        if (empty($settings['image_accordions'])) {
            return;
        }
        ?>

        <div <?php $this->print_render_attribute_string('eead-image-accordion'); ?>>
            <?php foreach ($settings['image_accordions'] as $key => $img_accordion) { ?>
                <?php
                $active = '';
                $tag = $img_accordion['image_accordion_link_image'] == 'yes' ? 'a' : 'div';
                $active = $img_accordion['image_accordion_is_active'];

                if ($img_accordion['image_accordion_link_image'] == 'yes') {
                    $this->add_render_attribute(
                        'eead-image-accordion-' . $key, [
                            'href' => esc_url($img_accordion['image_accordion_link']['url']),
                            'target' => $img_accordion['image_accordion_link']['is_external'] ? '_blank' : '_self',
                            'rel' => $img_accordion['image_accordion_link']['nofollow'] ? 'nofollow' : '',
                        ]
                    );
                }

                $this->add_render_attribute(
                    'eead-image-accordion-' . $key, [
                        'class' => [
                            'eead-image-accordion-item',
                            $active === 'yes' ? 'eead-tab-active' : ''],
                        'style' => "background-image: url(" . esc_url($img_accordion['image_accordion_bg']['url']) . ");",
                    ]
                );
                ?>

                <<?php echo esc_attr(eead_check_allowed_html_tags($tag)); ?> <?php $this->print_render_attribute_string('eead-image-accordion-' . $key); ?> >
                    <div class="eead-image-accordion-box">
                        <div class="eead-image-accordion-content">
                            <?php
                            if ($img_accordion['image_accordion_title']) {
                                printf('<%1$s class="eead-image-accordion-title">%2$s</%1$s>', esc_attr($settings['title_tag']), esc_html($img_accordion['image_accordion_title']));
                            }

                            if ($img_accordion['image_accordion_content']) {
                                ?>
                                <div class="eead-image-accordion-text">
                                    <?php echo wp_kses_post(parse_wisiwyg_content($img_accordion['image_accordion_content'])); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </<?php echo esc_attr(eead_check_allowed_html_tags($tag)); ?>>
            <?php } ?>
        </div>

        <?php
    }

}
