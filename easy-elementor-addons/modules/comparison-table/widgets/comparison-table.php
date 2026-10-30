<?php

namespace EasyElementorAddons\Modules\ComparisonTable\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Comparison Table Widget
 */
class ComparisonTable extends Widget_Base {

    public function get_name() {
        return 'eead-comparison-table';
    }

    public function get_title() {
        return esc_html__('Comparison Table', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-comparison-table';
    }

    public function get_keywords() {
        return ['comparison', 'compare', 'pricing', 'plans', 'features', 'table', 'eead'];
    }

    /**
     * Drop the inner .elementor-widget-container wrapper when Elementor's
     * Optimized Markup feature is active.
     */
    public function has_widget_inner_wrapper(): bool {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_columns', [
                'label' => esc_html__('Columns', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'features_title', [
                'label' => esc_html__('Feature Column Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Compare plans', 'easy-elementor-addons')
            ]
        );

        $column = new Repeater();

        $column->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Plan', 'easy-elementor-addons')
            ]
        );

        $column->add_control(
            'price', [
                'label' => esc_html__('Price', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => '$19'
            ]
        );

        $column->add_control(
            'period', [
                'label' => esc_html__('Period', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('/month', 'easy-elementor-addons')
            ]
        );

        $column->add_control(
            'description', [
                'label' => esc_html__('Short Description', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $column->add_control(
            'featured', [
                'label' => esc_html__('Highlight This Column', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $column->add_control(
            'badge', [
                'label' => esc_html__('Badge', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Most popular', 'easy-elementor-addons')
            ]
        );

        $column->add_control(
            'button_text', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Get started', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $column->add_control(
            'button_link', [
                'label' => esc_html__('Button Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com',
                'default' => ['url' => '#'],
                'condition' => [
                    'button_text!' => ''
                ]
            ]
        );

        $this->add_control(
            'columns', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $column->get_controls(),
                'default' => [
                    ['title' => esc_html__('Basic', 'easy-elementor-addons'), 'price' => '$0', 'period' => esc_html__('/month', 'easy-elementor-addons'), 'description' => esc_html__('For trying things out', 'easy-elementor-addons')],
                    ['title' => esc_html__('Pro', 'easy-elementor-addons'), 'price' => '$19', 'period' => esc_html__('/month', 'easy-elementor-addons'), 'description' => esc_html__('For growing businesses', 'easy-elementor-addons'), 'featured' => 'yes', 'badge' => esc_html__('Most popular', 'easy-elementor-addons')],
                    ['title' => esc_html__('Agency', 'easy-elementor-addons'), 'price' => '$49', 'period' => esc_html__('/month', 'easy-elementor-addons'), 'description' => esc_html__('For teams and clients', 'easy-elementor-addons')],
                ],
                'title_field' => '{{{ title }}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_rows', [
                'label' => esc_html__('Features', 'easy-elementor-addons')
            ]
        );

        $row = new Repeater();

        $row->add_control(
            'type', [
                'label' => esc_html__('Row Type', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'feature',
                'options' => [
                    'feature' => ['title' => esc_html__('Feature', 'easy-elementor-addons'), 'icon' => 'eicon-check'],
                    'group' => ['title' => esc_html__('Group Heading', 'easy-elementor-addons'), 'icon' => 'eicon-heading'],
                ]
            ]
        );

        $row->add_control(
            'feature', [
                'label' => esc_html__('Name', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Feature', 'easy-elementor-addons')
            ]
        );

        $row->add_control(
            'info', [
                'label' => esc_html__('Explanation', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => esc_html__('Shown in a small info tooltip beside the name.', 'easy-elementor-addons'),
                'condition' => [
                    'type' => 'feature'
                ]
            ]
        );

        $row->add_control(
            'values', [
                'label' => esc_html__('Values', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'yes | yes | yes',
                'description' => esc_html__('One value per column, separated by | . Type yes or no for a tick or a cross, or any text such as "10 GB".', 'easy-elementor-addons'),
                'condition' => [
                    'type' => 'feature'
                ]
            ]
        );

        $this->add_control(
            'rows', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $row->get_controls(),
                'default' => [
                    ['type' => 'group', 'feature' => esc_html__('Essentials', 'easy-elementor-addons')],
                    ['feature' => esc_html__('Websites', 'easy-elementor-addons'), 'values' => '1 | 5 | Unlimited'],
                    ['feature' => esc_html__('Storage', 'easy-elementor-addons'), 'values' => '1 GB | 50 GB | 500 GB'],
                    ['feature' => esc_html__('Custom domain', 'easy-elementor-addons'), 'values' => 'no | yes | yes'],
                    ['type' => 'group', 'feature' => esc_html__('Support', 'easy-elementor-addons')],
                    ['feature' => esc_html__('Email support', 'easy-elementor-addons'), 'values' => 'yes | yes | yes'],
                    ['feature' => esc_html__('Priority support', 'easy-elementor-addons'), 'info' => esc_html__('Replies within two hours, every day.', 'easy-elementor-addons'), 'values' => 'no | yes | yes'],
                    ['feature' => esc_html__('Account manager', 'easy-elementor-addons'), 'values' => 'no | no | yes'],
                ],
                'title_field' => '<# if ( "group" === type ) { #><strong>{{{ feature }}}</strong><# } else { #>{{{ feature }}}<# } #>'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings', [
                'label' => esc_html__('Settings', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'yes_icon', [
                'label' => esc_html__('Yes Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'no_icon', [
                'label' => esc_html__('No Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-times',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'button_position', [
                'label' => esc_html__('Buttons', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__('Under the Price', 'easy-elementor-addons'),
                    'bottom' => esc_html__('Below the Table', 'easy-elementor-addons'),
                    'both' => esc_html__('Both', 'easy-elementor-addons'),
                    'none' => esc_html__('Hidden', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'sticky_first', [
                'label' => esc_html__('Keep Feature Names in View', 'easy-elementor-addons'),
                'description' => esc_html__('On small screens the table scrolls sideways while the feature column stays put.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'prefix_class' => 'eead-ct-sticky-'
            ]
        );

        $this->add_responsive_control(
            'min_width', [
                'label' => esc_html__('Minimum Table Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 300, 'max' => 1400]],
                'default' => ['size' => 640],
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table' => 'min-width: {{SIZE}}px',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Table */
        $this->start_controls_section(
            'section_style_table', [
                'label' => esc_html__('Table', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'table_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-bg: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'line_color', [
                'label' => esc_html__('Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-line: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'table_border',
                'selector' => '{{WRAPPER}} .eead-ct'
            ]
        );

        $this->add_responsive_control(
            'table_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'table_shadow',
                'selector' => '{{WRAPPER}} .eead-ct'
            ]
        );

        $this->add_responsive_control(
            'cell_padding', [
                'label' => esc_html__('Cell Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table td, {{WRAPPER}} .eead-ct-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'row_hover', [
                'label' => esc_html__('Row Hover Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table tbody tr.eead-ct-row:hover > *' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Header */
        $this->start_controls_section(
            'section_style_header', [
                'label' => esc_html__('Plan Header', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ct-title'
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Title Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-title, {{WRAPPER}} .eead-ct-corner' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ct-price',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'price_color', [
                'label' => esc_html__('Price Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-price' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'desc_color', [
                'label' => esc_html__('Period & Description Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-period, {{WRAPPER}} .eead-ct-desc' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_bg', [
                'label' => esc_html__('Header Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table thead th' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        /* Style: Highlighted Column */
        $this->start_controls_section(
            'section_style_featured', [
                'label' => esc_html__('Highlighted Column', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'featured_bg', [
                'label' => esc_html__('Column Tint', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-featured-bg: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'featured_header_bg', [
                'label' => esc_html__('Header Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table thead th.eead-ct-featured' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'featured_header_color', [
                'label' => esc_html__('Header Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-table thead th.eead-ct-featured, {{WRAPPER}} .eead-ct-table thead th.eead-ct-featured .eead-ct-title, {{WRAPPER}} .eead-ct-table thead th.eead-ct-featured .eead-ct-price, {{WRAPPER}} .eead-ct-table thead th.eead-ct-featured .eead-ct-period, {{WRAPPER}} .eead-ct-table thead th.eead-ct-featured .eead-ct-desc' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'featured_border', [
                'label' => esc_html__('Outline Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-accent: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'badge_bg', [
                'label' => esc_html__('Badge Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-badge' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'badge_color', [
                'label' => esc_html__('Badge Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-badge' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Features */
        $this->start_controls_section(
            'section_style_features', [
                'label' => esc_html__('Features & Values', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'feature_typography',
                'label' => esc_html__('Feature Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ct-feature'
            ]
        );

        $this->add_control(
            'feature_color', [
                'label' => esc_html__('Feature Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-feature' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'value_typography',
                'label' => esc_html__('Value Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ct-value',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'value_color', [
                'label' => esc_html__('Value Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-value' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size', [
                'label' => esc_html__('Tick & Cross Size', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 8, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-mark' => 'font-size: {{SIZE}}px',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'yes_color', [
                'label' => esc_html__('Tick Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-yes: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'no_color', [
                'label' => esc_html__('Cross Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct' => '--eead-ct-no: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'group_heading', [
                'label' => esc_html__('Group Headings', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'group_typography',
                'selector' => '{{WRAPPER}} .eead-ct-group th'
            ]
        );

        $this->add_control(
            'group_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-group th' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'group_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-group th, {{WRAPPER}} .eead-ct-group td:not(.eead-ct-featured)' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Buttons */
        $this->start_controls_section(
            'section_style_buttons', [
                'label' => esc_html__('Buttons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_position!' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .eead-ct-button'
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-button' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-button' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_featured_color', [
                'label' => esc_html__('Highlighted Column Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-featured .eead-ct-button' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_featured_bg', [
                'label' => esc_html__('Highlighted Column Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-featured .eead-ct-button' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'button_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-button:hover, {{WRAPPER}} .eead-ct-button:focus-visible' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_bg_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-button:hover, {{WRAPPER}} .eead-ct-button:focus-visible' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-ct-button' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Words that mean a tick or a cross. */
    private function value_kind($value) {
        $v = strtolower(trim($value));
        if (in_array($v, ['yes', 'y', 'true', '✓', '✔', 'check'], true)) {
            return 'yes';
        }
        if (in_array($v, ['no', 'n', 'false', '✗', '✕', 'x', '-', '—'], true)) {
            return 'no';
        }
        return 'text';
    }

    private function render_button($column, $index) {
        if ('' === trim((string) $column['button_text'])) {
            return;
        }
        $key = 'button-' . $index . '-' . wp_rand();
        $this->add_render_attribute($key, 'class', 'eead-ct-button');
        if (!empty($column['button_link']['url'])) {
            $this->add_link_attributes($key, $column['button_link']);
        }
        echo '<a ' . $this->get_render_attribute_string($key) . '>' . esc_html($column['button_text']) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = array_values((array) $settings['columns']);
        $count = count($columns);

        if (!$count) {
            return;
        }

        $buttons = in_array($settings['button_position'], ['top', 'bottom', 'both', 'none'], true) ? $settings['button_position'] : 'bottom';
        $featured = [];
        foreach ($columns as $i => $column) {
            $featured[$i] = 'yes' === $column['featured'] ? ' eead-ct-featured' : '';
        }

        ob_start();
        Icons_Manager::render_icon($settings['yes_icon'], ['aria-hidden' => 'true']);
        $yes = ob_get_clean();
        ob_start();
        Icons_Manager::render_icon($settings['no_icon'], ['aria-hidden' => 'true']);
        $no = ob_get_clean();
        ?>
        <div class="eead-ct">
            <div class="eead-ct-scroll">
                <table class="eead-ct-table">
                    <thead>
                        <tr>
                            <th class="eead-ct-corner" scope="col"><?php echo esc_html($settings['features_title']); ?></th>
                            <?php foreach ($columns as $i => $column) { ?>
                                <th scope="col" class="eead-ct-plan elementor-repeater-item-<?php echo esc_attr($column['_id'] . $featured[$i]); ?>">
                                    <?php if ('' !== trim((string) $column['badge'])) { ?>
                                        <span class="eead-ct-badge"><?php echo esc_html($column['badge']); ?></span>
                                    <?php } ?>
                                    <span class="eead-ct-title"><?php echo esc_html($column['title']); ?></span>
                                    <?php if ('' !== trim((string) $column['price'])) { ?>
                                        <span class="eead-ct-pricing"><span class="eead-ct-price"><?php echo esc_html($column['price']); ?></span><?php if ('' !== trim((string) $column['period'])) { ?><span class="eead-ct-period"><?php echo esc_html($column['period']); ?></span><?php } ?></span>
                                    <?php } ?>
                                    <?php if ('' !== trim((string) $column['description'])) { ?>
                                        <span class="eead-ct-desc"><?php echo esc_html($column['description']); ?></span>
                                    <?php } ?>
                                    <?php
                                    if ('top' === $buttons || 'both' === $buttons) {
                                        $this->render_button($column, $i);
                                    }
                                    ?>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ((array) $settings['rows'] as $r => $row) {
                            if ('group' === $row['type']) {
                                // One cell per column (not a colspan), so the highlighted column stays unbroken.
                                echo '<tr class="eead-ct-group"><th scope="rowgroup"><span class="eead-ct-group-label">' . esc_html($row['feature']) . '</span></th>';
                                for ($i = 0; $i < $count; $i++) {
                                    echo '<td class="eead-ct-group-cell' . esc_attr($featured[$i]) . '"></td>';
                                }
                                echo '</tr>';
                                continue;
                            }
                            $values = array_map('trim', explode('|', (string) $row['values']));
                            ?>
                            <tr class="eead-ct-row">
                                <th scope="row" class="eead-ct-feature">
                                    <?php echo esc_html($row['feature']); ?>
                                    <?php if ('' !== trim((string) $row['info'])) { ?>
                                        <span class="eead-ct-info" tabindex="0" aria-label="<?php echo esc_attr($row['info']); ?>"><span class="eead-ct-info-icon" aria-hidden="true">i</span><span class="eead-ct-tip" aria-hidden="true"><?php echo esc_html($row['info']); ?></span></span>
                                    <?php } ?>
                                </th>
                                <?php
                                for ($i = 0; $i < $count; $i++) {
                                    $value = isset($values[$i]) ? $values[$i] : '';
                                    $kind = $this->value_kind($value);
                                    echo '<td class="eead-ct-value' . esc_attr($featured[$i]) . '">';
                                    if ('yes' === $kind) {
                                        echo '<span class="eead-ct-mark eead-ct-yes">' . $yes . '<span class="screen-reader-text">' . esc_html__('Included', 'easy-elementor-addons') . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    } elseif ('no' === $kind) {
                                        echo '<span class="eead-ct-mark eead-ct-no">' . $no . '<span class="screen-reader-text">' . esc_html__('Not included', 'easy-elementor-addons') . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    } else {
                                        echo esc_html($value);
                                    }
                                    echo '</td>';
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <?php if ('bottom' === $buttons || 'both' === $buttons) { ?>
                        <tfoot>
                            <tr>
                                <td class="eead-ct-corner"></td>
                                <?php foreach ($columns as $i => $column) { ?>
                                    <td class="eead-ct-foot<?php echo esc_attr($featured[$i]); ?>"><?php $this->render_button($column, $i); ?></td>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php
    }

}
