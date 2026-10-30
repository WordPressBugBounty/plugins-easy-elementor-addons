<?php

namespace EasyElementorAddons\Modules\DataTable\Widgets;

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
 * Data Table Widget
 */
class DataTable extends Widget_Base {

    public function get_name() {
        return 'eead-data-table';
    }

    public function get_title() {
        return esc_html__('Data Table', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-data-table';
    }

    public function get_keywords() {
        return ['table', 'data table', 'csv', 'sortable', 'spreadsheet', 'eead'];
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
            'section_header', [
                'label' => esc_html__('Table Header', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'source', [
                'label' => esc_html__('Source', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => esc_html__('Build in Editor', 'easy-elementor-addons'),
                    'csv' => esc_html__('Paste CSV', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'csv', [
                'label' => esc_html__('CSV', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => "Plan,Price,Storage,Support\nStarter,\$9,10 GB,Email\nPro,\$29,100 GB,Priority\nBusiness,\$79,1 TB,24/7 phone",
                'description' => esc_html__('The first line is the header. Separate values with commas and wrap a value in double quotes if it contains a comma.', 'easy-elementor-addons'),
                'condition' => [
                    'source' => 'csv'
                ]
            ]
        );

        $header = new Repeater();

        $header->add_control(
            'text', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Column', 'easy-elementor-addons')
            ]
        );

        $header->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $header->add_control(
            'colspan', [
                'label' => esc_html__('Column Span', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'default' => 1
            ]
        );

        $header->add_control(
            'width', [
                'label' => esc_html__('Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => 1, 'max' => 100],
                    'px' => ['min' => 20, 'max' => 800],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $header->add_control(
            'align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th{{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'columns', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $header->get_controls(),
                'default' => [
                    ['text' => esc_html__('Plan', 'easy-elementor-addons')],
                    ['text' => esc_html__('Price', 'easy-elementor-addons')],
                    ['text' => esc_html__('Storage', 'easy-elementor-addons')],
                    ['text' => esc_html__('Support', 'easy-elementor-addons')],
                ],
                'title_field' => '{{{ text }}}',
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_body', [
                'label' => esc_html__('Table Body', 'easy-elementor-addons'),
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $body = new Repeater();

        $body->add_control(
            'action', [
                'label' => esc_html__('Add', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'cell',
                'options' => [
                    'row' => ['title' => esc_html__('New Row', 'easy-elementor-addons'), 'icon' => 'eicon-table-of-contents'],
                    'cell' => ['title' => esc_html__('Cell', 'easy-elementor-addons'), 'icon' => 'eicon-text-field'],
                ],
                'description' => esc_html__('"New Row" starts a row; the cells after it fill that row.', 'easy-elementor-addons')
            ]
        );

        $body->add_control(
            'text', [
                'label' => esc_html__('Content', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Cell', 'easy-elementor-addons'),
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://your-link.com',
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'colspan', [
                'label' => esc_html__('Column Span', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'default' => 1,
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'rowspan', [
                'label' => esc_html__('Row Span', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'default' => 1,
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'is_header', [
                'label' => esc_html__('Row Header Cell', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Styles the cell like a header, such as the first cell of a row.', 'easy-elementor-addons'),
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'cell_custom_style', [
                'label' => esc_html__('Custom Style', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'condition' => [
                    'action' => 'cell'
                ]
            ]
        );

        $body->add_control(
            'cell_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table {{CURRENT_ITEM}}, {{WRAPPER}} .eead-data-table {{CURRENT_ITEM}} a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'action' => 'cell',
                    'cell_custom_style' => 'yes'
                ]
            ]
        );

        $body->add_control(
            'cell_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'action' => 'cell',
                    'cell_custom_style' => 'yes'
                ]
            ]
        );

        $body->add_control(
            'cell_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table {{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
                ],
                'condition' => [
                    'action' => 'cell',
                    'cell_custom_style' => 'yes'
                ]
            ]
        );

        $default_rows = [];
        foreach ([['Starter', '$9', '10 GB', 'Email'], ['Pro', '$29', '100 GB', 'Priority'], ['Business', '$79', '1 TB', '24/7 phone']] as $row) {
            $default_rows[] = ['action' => 'row'];
            foreach ($row as $cell) {
                $default_rows[] = ['action' => 'cell', 'text' => $cell];
            }
        }

        $this->add_control(
            'rows', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $body->get_controls(),
                'default' => $default_rows,
                'title_field' => '<# if ( "row" === action ) { #><strong>&mdash; ' . esc_html__('New Row', 'easy-elementor-addons') . ' &mdash;</strong><# } else { #>{{{ text }}}<# } #>'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features', [
                'label' => esc_html__('Features', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'sortable', [
                'label' => esc_html__('Sortable Columns', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Not available when body cells span several rows.', 'easy-elementor-addons'),
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'searchable', [
                'label' => esc_html__('Search Box', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'search_placeholder', [
                'label' => esc_html__('Search Placeholder', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Search…', 'easy-elementor-addons'),
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'empty_text', [
                'label' => esc_html__('No Results Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('No matching rows.', 'easy-elementor-addons'),
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'paginate', [
                'label' => esc_html__('Pagination', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'per_page', [
                'label' => esc_html__('Rows per Page', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 500,
                'default' => 10,
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'responsive', [
                'label' => esc_html__('On Small Screens', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'scroll',
                'options' => [
                    'scroll' => esc_html__('Scroll Sideways', 'easy-elementor-addons'),
                    'stack' => esc_html__('Stack Rows as Cards', 'easy-elementor-addons'),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'stack_on', [
                'label' => esc_html__('Stack On', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'mobile',
                'options' => [
                    'mobile' => esc_html__('Mobile', 'easy-elementor-addons'),
                    'tablet' => esc_html__('Tablet and Mobile', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'responsive' => 'stack'
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
                    '{{WRAPPER}} .eead-data-table' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'table_border',
                'selector' => '{{WRAPPER}} .eead-dt-scroll'
            ]
        );

        $this->add_responsive_control(
            'table_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-scroll' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'table_shadow',
                'selector' => '{{WRAPPER}} .eead-dt-scroll'
            ]
        );

        $this->add_control(
            'cell_border_heading', [
                'label' => esc_html__('Cell Borders', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'cell_border_style', [
                'label' => esc_html__('Lines', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'rows',
                'options' => [
                    'rows' => esc_html__('Between Rows', 'easy-elementor-addons'),
                    'grid' => esc_html__('Full Grid', 'easy-elementor-addons'),
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-dt-lines-'
            ]
        );

        $this->add_control(
            'cell_border_color', [
                'label' => esc_html__('Line Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table' => '--eead-dt-line: {{VALUE}}',
                ],
                'condition' => [
                    'cell_border_style!' => 'none'
                ]
            ]
        );

        $this->add_control(
            'cell_border_width', [
                'label' => esc_html__('Line Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 1, 'max' => 6]],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table' => '--eead-dt-line-width: {{SIZE}}px',
                ],
                'condition' => [
                    'cell_border_style!' => 'none'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Header */
        $this->start_controls_section(
            'section_style_header', [
                'label' => esc_html__('Header', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'header_typography',
                'selector' => '{{WRAPPER}} .eead-data-table thead th'
            ]
        );

        $this->add_control(
            'header_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th, {{WRAPPER}} .eead-data-table thead .eead-dt-sort' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'header_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead th' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'header_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table thead .eead-dt-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-data-table thead .eead-dt-icon svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'sort_icon_color', [
                'label' => esc_html__('Sort Arrow Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-sort-arrow' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'sortable' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Body */
        $this->start_controls_section(
            'section_style_body', [
                'label' => esc_html__('Body', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'body_typography',
                'selector' => '{{WRAPPER}} .eead-data-table tbody td, {{WRAPPER}} .eead-data-table tbody th'
            ]
        );

        $this->add_responsive_control(
            'body_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody td, {{WRAPPER}} .eead-data-table tbody th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'body_align', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody td, {{WRAPPER}} .eead-data-table tbody th' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->start_controls_tabs('body_tabs');

        $this->start_controls_tab(
            'body_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'body_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody td, {{WRAPPER}} .eead-data-table tbody th' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'body_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody tr' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'striped', [
                'label' => esc_html__('Striped Rows', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'eead-dt-striped-'
            ]
        );

        $this->add_control(
            'stripe_bg', [
                'label' => esc_html__('Stripe Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#F6F7F9',
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table' => '--eead-dt-stripe: {{VALUE}}',
                ],
                'condition' => [
                    'striped' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'row_header_color', [
                'label' => esc_html__('Row Header Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody th' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'link_color', [
                'label' => esc_html__('Link Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'body_hover', [
                'label' => esc_html__('Row Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'body_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody tr:hover td, {{WRAPPER}} .eead-data-table tbody tr:hover th' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'body_bg_hover', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody tr:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'body_icon_color', [
                'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table tbody .eead-dt-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-data-table tbody .eead-dt-icon svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'source' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'stack_label_color', [
                'label' => esc_html__('Card Label Color', 'easy-elementor-addons'),
                'description' => esc_html__('The column name shown beside each value when rows stack as cards.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-data-table' => '--eead-dt-label: {{VALUE}}',
                ],
                'condition' => [
                    'responsive' => 'stack'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Search & Pagination */
        $this->start_controls_section(
            'section_style_tools', [
                'label' => esc_html__('Search & Pagination', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'searchable', 'operator' => '==', 'value' => 'yes'],
                        ['name' => 'paginate', 'operator' => '==', 'value' => 'yes'],
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'search_width', [
                'label' => esc_html__('Search Width', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 120, 'max' => 800],
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-search' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'search_align', [
                'label' => esc_html__('Search Position', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => esc_html__('Left', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-left'],
                    'center' => ['title' => esc_html__('Center', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-center'],
                    'flex-end' => ['title' => esc_html__('Right', 'easy-elementor-addons'), 'icon' => 'eicon-h-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-toolbar' => 'justify-content: {{VALUE}}',
                ],
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'search_color', [
                'label' => esc_html__('Search Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-search' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'search_bg', [
                'label' => esc_html__('Search Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-search' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'search_border',
                'selector' => '{{WRAPPER}} .eead-dt-search',
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'search_radius', [
                'label' => esc_html__('Search Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'searchable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'page_heading', [
                'label' => esc_html__('Pagination', 'easy-elementor-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'page_color', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-page' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'page_bg', [
                'label' => esc_html__('Button Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-page' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'page_active_color', [
                'label' => esc_html__('Current Page Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-page[aria-current="page"]' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'page_active_bg', [
                'label' => esc_html__('Current Page Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-page[aria-current="page"]' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'condition' => [
                    'paginate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'info_color', [
                'label' => esc_html__('Info Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-dt-info' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /** Text allowed in a cell: inline formatting and line breaks. */
    private function cell_html($text) {
        return wp_kses(nl2br($text), [
            'br' => [],
            'em' => [],
            'strong' => [],
            'b' => [],
            'i' => [],
            'mark' => [],
            'span' => ['class' => []],
            'small' => [],
            'del' => [],
            'sup' => [],
            'sub' => [],
            'code' => [],
        ]);
    }

    /** Parse pasted CSV, honouring quoted values that contain commas or line breaks. */
    private function parse_csv($csv) {
        $rows = [];
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, trim((string) $csv));
        rewind($handle);
        while (false !== ($row = fgetcsv($handle, 0, ',', '"', '\\'))) {
            if ([null] === $row) {
                continue;
            }
            $rows[] = array_map('trim', $row);
        }
        fclose($handle);
        return $rows;
    }

    /** Header cells and body rows in one shape for both sources. */
    private function build_table($settings) {
        $head = [];
        $body = [];

        if ('csv' === $settings['source']) {
            $rows = $this->parse_csv($settings['csv']);
            foreach ((array) array_shift($rows) as $title) {
                $head[] = ['id' => '', 'html' => esc_html($title), 'label' => $title, 'icon' => null, 'colspan' => 1];
            }
            foreach ($rows as $row) {
                $cells = [];
                foreach ($row as $value) {
                    $cells[] = ['id' => '', 'html' => esc_html($value), 'icon' => null, 'link' => null, 'colspan' => 1, 'rowspan' => 1, 'th' => false];
                }
                $body[] = $cells;
            }
            return [$head, $body];
        }

        foreach ((array) $settings['columns'] as $column) {
            $head[] = [
                'id' => $column['_id'],
                'html' => esc_html($column['text']),
                'label' => $column['text'],
                'icon' => !empty($column['icon']['value']) ? $column['icon'] : null,
                'colspan' => max(1, (int) $column['colspan']),
            ];
        }

        $current = null;
        foreach ((array) $settings['rows'] as $item) {
            if ('row' === $item['action']) {
                if (null !== $current) {
                    $body[] = $current;
                }
                $current = [];
                continue;
            }
            if (null === $current) {
                $current = [];
            }
            $current[] = [
                'id' => $item['_id'],
                'html' => $this->cell_html($item['text']),
                'icon' => !empty($item['icon']['value']) ? $item['icon'] : null,
                'link' => !empty($item['link']['url']) ? $item['link'] : null,
                'colspan' => max(1, (int) $item['colspan']),
                'rowspan' => max(1, (int) $item['rowspan']),
                'th' => 'yes' === $item['is_header'],
            ];
        }
        if (null !== $current) {
            $body[] = $current;
        }

        return [$head, $body];
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        list($head, $body) = $this->build_table($settings);

        if (empty($head) && empty($body)) {
            return;
        }

        // Column titles by position, so stacked cards can label every value.
        $labels = [];
        foreach ($head as $cell) {
            for ($i = 0; $i < $cell['colspan']; $i++) {
                $labels[] = $cell['label'];
            }
        }

        $has_rowspan = false;
        foreach ($body as $row) {
            foreach ($row as $cell) {
                if ($cell['rowspan'] > 1) {
                    $has_rowspan = true;
                }
            }
        }

        $sortable = 'yes' === $settings['sortable'] && !$has_rowspan && !empty($head);
        $searchable = 'yes' === $settings['searchable'];
        $paginate = 'yes' === $settings['paginate'];
        $responsive = 'stack' === $settings['responsive'] ? 'stack-' . ('tablet' === $settings['stack_on'] ? 'tablet' : 'mobile') : 'scroll';

        $this->add_render_attribute('wrap', [
            'class' => ['eead-data-table-wrap', 'eead-dt-' . $responsive],
            'data-settings' => wp_json_encode([
                'sortable' => $sortable,
                'search' => $searchable,
                'perPage' => $paginate ? max(1, (int) $settings['per_page']) : 0,
                'empty' => $searchable ? $settings['empty_text'] : '',
                /* translators: 1: first row shown, 2: last row shown, 3: total rows */
                'info' => esc_html__('Showing %1$s–%2$s of %3$s', 'easy-elementor-addons'),
                'prev' => esc_html__('Previous page', 'easy-elementor-addons'),
                'next' => esc_html__('Next page', 'easy-elementor-addons'),
                'page' => esc_html__('Page %s', 'easy-elementor-addons'),
            ]),
        ]);
        ?>
        <div <?php $this->print_render_attribute_string('wrap'); ?>>
            <?php if ($searchable) { ?>
                <div class="eead-dt-toolbar">
                    <input type="search" class="eead-dt-search" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" aria-label="<?php esc_attr_e('Search the table', 'easy-elementor-addons'); ?>">
                </div>
            <?php } ?>
            <div class="eead-dt-scroll">
                <table class="eead-data-table">
                    <?php if ($head) { ?>
                        <thead>
                            <tr>
                                <?php
                                $col = 0;
                                foreach ($head as $cell) {
                                    $classes = $cell['id'] ? ' class="elementor-repeater-item-' . esc_attr($cell['id']) . '"' : '';
                                    $span = $cell['colspan'] > 1 ? ' colspan="' . (int) $cell['colspan'] . '"' : '';
                                    $sort = $sortable && 1 === $cell['colspan'];
                                    echo '<th scope="col"' . $classes . $span . ($sort ? ' aria-sort="none" data-col="' . (int) $col . '"' : '') . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    if ($sort) {
                                        echo '<button type="button" class="eead-dt-sort">';
                                    }
                                    echo '<span class="eead-dt-th-inner">';
                                    if ($cell['icon']) {
                                        echo '<span class="eead-dt-icon">';
                                        Icons_Manager::render_icon($cell['icon'], ['aria-hidden' => 'true']);
                                        echo '</span>';
                                    }
                                    echo '<span>' . $cell['html'] . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in build_table().
                                    if ($sort) {
                                        echo '<span class="eead-dt-sort-arrow" aria-hidden="true"></span>';
                                    }
                                    echo '</span>';
                                    if ($sort) {
                                        echo '</button>';
                                    }
                                    echo '</th>';
                                    $col += $cell['colspan'];
                                }
                                ?>
                            </tr>
                        </thead>
                    <?php } ?>
                    <tbody>
                        <?php
                        foreach ($body as $r => $row) {
                            echo '<tr>';
                            $col = 0;
                            foreach ($row as $c => $cell) {
                                $tag = $cell['th'] ? 'th' : 'td';
                                $attrs = $cell['th'] ? ' scope="row"' : '';
                                if ($cell['id']) {
                                    $attrs .= ' class="elementor-repeater-item-' . esc_attr($cell['id']) . '"';
                                }
                                if ($cell['colspan'] > 1) {
                                    $attrs .= ' colspan="' . (int) $cell['colspan'] . '"';
                                }
                                if ($cell['rowspan'] > 1) {
                                    $attrs .= ' rowspan="' . (int) $cell['rowspan'] . '"';
                                }
                                if (isset($labels[$col]) && '' !== $labels[$col]) {
                                    $attrs .= ' data-label="' . esc_attr($labels[$col]) . '"';
                                }
                                echo '<' . $tag . $attrs . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                // One wrapper, so stacked cards show the label and the whole value side by side.
                                // Cells holding only an icon (a tick, a cross) center it without a gap after.
                                echo '<span class="eead-dt-cell' . ('' === trim(wp_strip_all_tags($cell['html'])) ? ' eead-dt-icon-only' : '') . '">';
                                if ($cell['link']) {
                                    $key = 'link-' . $r . '-' . $c;
                                    $this->add_link_attributes($key, $cell['link']);
                                    echo '<a ' . $this->get_render_attribute_string($key) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                }
                                if ($cell['icon']) {
                                    echo '<span class="eead-dt-icon">';
                                    Icons_Manager::render_icon($cell['icon'], ['aria-hidden' => 'true']);
                                    echo '</span>';
                                }
                                echo $cell['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in build_table().
                                if ($cell['link']) {
                                    echo '</a>';
                                }
                                echo '</span>';
                                echo '</' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                $col += $cell['colspan'];
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php if ($searchable || $paginate) { ?>
                <div class="eead-dt-footer">
                    <div class="eead-dt-info" aria-live="polite"></div>
                    <?php if ($paginate) { ?>
                        <nav class="eead-dt-pagination" aria-label="<?php esc_attr_e('Table pages', 'easy-elementor-addons'); ?>"></nav>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }

}
