<?php

namespace EasyElementorAddons\Modules\Progressbar\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Progressbar extends Widget_Base {

    public function get_name() {
        return 'eead-progressbar';
    }

    public function get_title() {
        return esc_html__('Progress Bar', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-progress-bar';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['waypoint'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'progressbar', [
                'label' => esc_html__('Progress Bar', 'easy-elementor-addons')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'progressbar_label', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'progressbar_percentage', [
                'label' => esc_html__('Percentage', 'easy-elementor-addons'),
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
                    'size' => '90',
                    'unit' => 'px'
                ]
            ]
        );

        $this->add_control(
            'progressbar_block', [
                'label' => esc_html__('Add Progress Bars', 'easy-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'progressbar_label' => esc_html__('Progress Bar #1', 'easy-elementor-addons'),
                    ]
                ],
                'title_field' => '{{{ progressbar_label }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'progressbar_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'progressbar_style', [
                'label' => esc_html__('Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'easy-elementor-addons'),
                    'style2' => esc_html__('Style 2', 'easy-elementor-addons'),
                    'style3' => esc_html__('Style 3', 'easy-elementor-addons'),
                    'style4' => esc_html__('Style 4', 'easy-elementor-addons')
                ]
            ]
        );

        $this->add_control(
            'label_alignment', [
                'label' => esc_html__('Label Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ),
                ),
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-progress label' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'progressbar_style' => ['style2', 'style3']
                ]
            ]
        );

        $this->add_control(
            'label_position', [
                'label' => esc_html__('Label Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'above',
                'options' => [
                    'above' => esc_html__('Above Bar', 'easy-elementor-addons'),
                    'below' => esc_html__('Below Bar', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'progressbar_style' => ['style1', 'style3', 'style4']
                ],
                'prefix_class' => 'eead-progressbar-label-'
            ]
        );

        $this->add_control(
            'percentage_alignment', [
                'label' => esc_html__('Percentage Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('Left', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__('Center', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__('Right', 'easy-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ),
                ),
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .eead-progress .eead-progressbar-percentage' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'progressbar_style' => ['style2', 'style3']
                ]
            ]
        );

        $this->add_responsive_control(
            'progress_spacing', [
                'label' => esc_html__('Spacing', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-progress' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'progressbar_spacing', [
                'label' => esc_html__('Spacing Between Progress Bars', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-progressbar-container' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'reverse_position', [
                'label' => esc_html__('Reverse Label & Precentage Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'progressbar_style' => ['style2']
                ],
                'prefix_class' => 'eead-progressbar-alter-'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'label_style', [
                'label' => esc_html__('Label', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'label_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-progress label' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-progress label'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'percent_style', [
                'label' => esc_html__('Percent', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'percent_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-progress .eead-progressbar-percentage' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'percent_color3', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFF',
                'selectors' => [
                    '{{WRAPPER}} .eead-progress .eead-progressbar-percentage' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'progressbar_style' => ['style3']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'percent_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-progress .eead-progressbar-percentage'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'progressbar_style_section', [
                'label' => esc_html__('Progress Bar', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'progressbar_bg_header', [
                'label' => esc_html__('Bar Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'progressbar_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-progressbar'
            ]
        );

        $this->add_control(
            'progress_length_header', [
                'label' => esc_html__('Active Progress Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(), [
                'name' => 'progress_length_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eead-progressbar-length'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'progressbar_border',
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
                'selector' => '{{WRAPPER}} .eead-progressbar'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'progressbar_shadow',
                'selector' => '{{WRAPPER}} .eead-progressbar'
            ]
        );

        $this->add_responsive_control(
            'progressbar_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-progressbar' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'progressbar_height', [
                'label' => esc_html__('Progress Bar Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'progressbar_style!' => ['style3']
                ]
            ]
        );

        $this->add_responsive_control(
            'progressbar_border_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-progressbar-length, {{WRAPPER}} .eead-progressbar' => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $progressbars = $settings['progressbar_block'];
        ?>
        <div class="eead-progressbar-container eead-progressbar-<?php echo esc_attr($settings['progressbar_style']); ?>">
            <?php
            foreach ($progressbars as $progressbar) {
                $percentage = $progressbar['progressbar_percentage']['size'];
                ?>
                <div class="eead-progress">
                    <?php
                    switch ($settings['progressbar_style']) {
                        case 'style1':
                            ?>
                            <div class="eead-progressbar-header">
                                <label><?php echo esc_html($progressbar['progressbar_label']); ?></label>
                                <div class="eead-progressbar-percentage"><?php echo absint($percentage) . "%"; ?></div>
                            </div>
                            <div class="eead-progressbar" data-width="<?php echo absint($percentage); ?>">
                                <div class="eead-progressbar-length"></div>
                            </div>
                            <?php
                            break;

                        case 'style2':
                            ?>
                            <label><?php echo esc_html($progressbar['progressbar_label']); ?></label>
                            <div class="eead-progressbar" data-width="<?php echo absint($percentage); ?>">
                                <div class="eead-progressbar-length"></div>
                            </div>
                            <div class="eead-progressbar-percentage"><?php echo absint($percentage) . "%"; ?></div>
                            <?php
                            break;

                        case 'style3':
                            ?>
                            <label><?php echo esc_html($progressbar['progressbar_label']); ?></label>
                            <div class="eead-progressbar" data-width="<?php echo absint($percentage); ?>">
                                <div class="eead-progressbar-length">
                                    <div class="eead-progressbar-percentage"><?php echo absint($percentage) . "%"; ?></div>
                                </div>
                            </div>
                            <?php
                            break;

                        case 'style4':
                            ?>
                            <label><?php echo esc_html($progressbar['progressbar_label']); ?></label>
                            <div class="eead-progressbar" data-width="<?php echo absint($percentage); ?>">
                                <div class="eead-progressbar-length">
                                    <div class="eead-progressbar-percentage"><?php echo absint($percentage) . "%"; ?></div>
                                </div>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

}
