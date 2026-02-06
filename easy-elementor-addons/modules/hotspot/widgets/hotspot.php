<?php

namespace EasyElementorAddons\Modules\Hotspot\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Hotspot extends Widget_Base {

    public function get_name() {
        return 'eead-hotspot';
    }

    public function get_title() {
        return esc_html__('Hotspot', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-hot-spot';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'hotspot', [
                'label' => esc_html__('Hot Spot', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'image', [
                'label' => esc_html__('Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumbnail',
                'default' => 'full',
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs(
            'points_tab'
        );

        $repeater->start_controls_tab(
            'points_content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Title', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'content', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            ]
        );

        $repeater->add_control(
            'tooltip_position', [
                'label' => esc_html__('Tool Tip Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'easy-elementor-addons'),
                    'left-middle' => esc_html__('Left Middle', 'easy-elementor-addons'),
                    'right-middle' => esc_html__('Right Middle', 'easy-elementor-addons'),
                    'top-left' => esc_html__('Top Left', 'easy-elementor-addons'),
                    'top-middle' => esc_html__('Top Middle', 'easy-elementor-addons'),
                    'top-right' => esc_html__('Top Right', 'easy-elementor-addons'),
                    'bottom-left' => esc_html__('Bottom Left', 'easy-elementor-addons'),
                    'bottom-middle' => esc_html__('Bottom Middle', 'easy-elementor-addons'),
                    'bottom-right' => esc_html__('Bottom Right', 'easy-elementor-addons')
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'points_position', [
                'label' => esc_html__('Style/Position', 'easy-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'hotspot_type', [
                'label' => esc_html__('Hotspot Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => array(
                    'icon' => array(
                        'title' => esc_html__('Icon', 'easy-elementor-addons'),
                        'icon' => 'eicon-star',
                    ),
                    'image' => array(
                        'title' => esc_html__('Image', 'easy-elementor-addons'),
                        'icon' => 'eicon-image',
                    ),
                ),
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'icon', [
                'label' => esc_html__('Hotspot Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'eicon-plus',
                    'library' => 'eicon'
                ],
                'condition' => ['hotspot_type' => 'icon']
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__('Hotspot Image', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'condition' => ['hotspot_type' => 'image']
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(), [
                'name' => 'thumb',
                'default' => 'thumbnail',
                'condition' => ['hotspot_type' => 'image']
            ]
        );

        $repeater->add_control(
            'text_align', [
                'label' => esc_html__('Text Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-item{{CURRENT_ITEM}} .eead-hotspot-content' => 'text-align: {{VALUE}}'
                ],
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'x_position', [
                'label' => esc_html__('Hot Spot Horizontal Postion(%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-item{{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $repeater->add_control(
            'y_position', [
                'label' => esc_html__('Hot Spot Vertical Postion(%)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-item{{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $repeater->add_responsive_control(
            'content_width', [
                'label' => esc_html__('Content Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 300,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-item{{CURRENT_ITEM}} .eead-hotspot-content' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_control(
            'enable', [
                'label' => esc_html__('Enable', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hotspot_points', [
                'label' => esc_html__('Add Hot Spots', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_settings', [
                'label' => esc_html__('General Settings', 'easy-elementor-addons'),
            ]
        );

        $this->add_control(
            'content_open_type', [
                'label' => esc_html__('Content Open Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'open-onhover',
                'options' => [
                    'open-onclick' => esc_html__('On Click', 'easy-elementor-addons'),
                    'open-onhover' => esc_html__('On Hover', 'easy-elementor-addons')
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tooltip_position', [
                'label' => esc_html__('Tool Tip Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom-middle',
                'options' => [
                    'left-middle' => esc_html__('Left Middle', 'easy-elementor-addons'),
                    'right-middle' => esc_html__('Right Middle', 'easy-elementor-addons'),
                    'top-left' => esc_html__('Top Left', 'easy-elementor-addons'),
                    'top-middle' => esc_html__('Top Middle', 'easy-elementor-addons'),
                    'top-right' => esc_html__('Top Right', 'easy-elementor-addons'),
                    'bottom-left' => esc_html__('Bottom Left', 'easy-elementor-addons'),
                    'bottom-middle' => esc_html__('Bottom Middle', 'easy-elementor-addons'),
                    'bottom-right' => esc_html__('Bottom Right', 'easy-elementor-addons')
                ],
            ]
        );

        $this->add_control(
            'enable_pulse_animation', [
                'label' => esc_html__('Pulse Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pulse_duration', [
                'label' => esc_html__('Pulse Duration(in ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 600,
                        'max' => 6000,
                        'step' => 100
                    ]
                ],
                'default' => [
                    'size' => 2000,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a .eead-pulse' => 'animation-duration: {{SIZE}}ms;'
                ],
                'condition' => ['enable_pulse_animation' => 'yes']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style', [
                'label' => esc_html__('Hot Spot', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a .eead-pulse' => 'border: 5px solid {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a svg' => 'fill: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eead-hotspot .eead-hotspot-item a svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_size', [
                'label' => esc_html__('Icon Container Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot' => '--eead-hotspot-box-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tooltip_style', [
                'label' => esc_html__('Tool Tip Box', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_bg_color', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content,  {{WRAPPER}} .eead-hotspot .eead-hotspot-content:after' => 'background: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'tooltip_border',
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
                'selector' => '{{WRAPPER}} .eead-hotspot-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'tooltip_border_box_shadow',
                'selector' => '{{WRAPPER}} .eead-hotspot-content',
            ]
        );

        $this->add_responsive_control(
            'tooltip_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content h4' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-hotspot-content h4',
            ]
        );

        $this->add_responsive_control(
            'title_spacing', [
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
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content h4' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'description_style', [
                'label' => esc_html__('Description', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-hotspot-content .eead-hotspot-desc' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-hotspot-content .eead-hotspot-desc',
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="eead-hotspot-container">
            <div class="eead-hotspot eead-<?php echo esc_attr($settings['content_open_type']); ?>">

                <?php
                if (!empty($settings['image']['url'])) {
                    $this->add_render_attribute('image', 'src', esc_url($settings['image']['url']));
                    $this->add_render_attribute('image', 'class', 'eead-hotspot-image');
                    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
                    echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image'));
                }
                ?>

                <?php
                if (isset($settings['hotspot_points']) && !empty($settings['hotspot_points'])) {
                    foreach ($settings['hotspot_points'] as $key => $item) {

                        if ($item['enable'] != 'yes') {
                            continue;
                        }
                        ?>
                        <div class="eead-hotspot-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                            <a href="javascript:void()">
                                <?php
                                $this->pulsate_animation();
                                if ($item['hotspot_type'] == 'icon' && $item['icon']['value']) {
                                    Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                                } elseif ($item['hotspot_type'] == 'image' && $item['image']['url']) {
                                    echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($item, 'thumb', 'image'));
                                }
                                ?>
                            </a>
                            <?php
                            $this->get_content($key);
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function pulsate_animation() {
        $settings = $this->get_settings_for_display();
        if ($settings['enable_pulse_animation'] == 'yes') {
            echo '<div class="eead-pulse"></div>';
        }
    }

    protected function get_content($key) {
        $settings = $this->get_settings_for_display();
        $item = $settings['hotspot_points'][$key];
        $tooltip_pos = $item['tooltip_position'] !== 'default' ? $item['tooltip_position'] : $settings['tooltip_position'];
        ?>
        <div class="eead-hotspot-content eead-<?php echo esc_attr($tooltip_pos); ?>">
            <?php
            if (!empty($item['title'])) {
                ?>
                <h4><?php echo esc_html($item['title']); ?></h4>
                <?php
            }

            if (!empty($item['content'])) {
                ?>
                <div class="eead-hotspot-desc">
                    <?php
                    echo wp_kses_post(do_shortcode($item['content']));
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}
