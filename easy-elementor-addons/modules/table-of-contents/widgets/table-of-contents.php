<?php

namespace EasyElementorAddons\Modules\TableOfContents\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Table of Contents Widget
 */
class TableOfContents extends Widget_Base {

    public function get_name() {
        return 'eead-table-of-contents';
    }

    public function get_title() {
        return esc_html__('Table of Contents', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-table-of-contents';
    }

    public function get_keywords() {
        return ['table of contents', 'toc', 'contents', 'index', 'headings', 'anchor', 'eead'];
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
            'section_content', [
                'label' => esc_html__('Table of Contents', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('On this page', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'title_tag', [
                'label' => esc_html__('Title HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'div',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'headings', [
                'label' => esc_html__('Include Headings', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['h2', 'h3'],
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'container', [
                'label' => esc_html__('Look Inside', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '.entry-content',
                'description' => esc_html__('A CSS selector for the area to collect headings from. Leave empty to use the content this widget is part of.', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'exclude', [
                'label' => esc_html__('Exclude', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '.sidebar, .no-toc',
                'description' => esc_html__('Headings inside these selectors are left out. Headings with the class eead-toc-skip are always left out.', 'easy-elementor-addons'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'min_headings', [
                'label' => esc_html__('Minimum Headings', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'default' => 2,
                'description' => esc_html__('The box is hidden when the page has fewer headings than this.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'hierarchical', [
                'label' => esc_html__('Nested List', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Shows lower headings indented under the heading above them.', 'easy-elementor-addons'),
                'separator' => 'before',
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'marker', [
                'label' => esc_html__('Markers', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'numbers',
                'options' => [
                    'numbers' => esc_html__('Numbers (1, 1.1)', 'easy-elementor-addons'),
                    'bullets' => esc_html__('Bullets', 'easy-elementor-addons'),
                    'icon' => esc_html__('Icon', 'easy-elementor-addons'),
                    'none' => esc_html__('None', 'easy-elementor-addons'),
                ],
                'prefix_class' => 'eead-toc-marker-',
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'marker_icon', [
                'label' => esc_html__('Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'marker' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'word_wrap', [
                'label' => esc_html__('Keep Items on One Line', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'eead-toc-ellipsis-',
                'description' => esc_html__('Long headings are cut short with an ellipsis.', 'easy-elementor-addons')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_behaviour', [
                'label' => esc_html__('Behaviour', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'collapsible', [
                'label' => esc_html__('Collapsible', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'render_type' => 'template',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'collapsed', [
                'label' => esc_html__('Start Collapsed On', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Never', 'easy-elementor-addons'),
                    'mobile' => esc_html__('Mobile', 'easy-elementor-addons'),
                    'tablet' => esc_html__('Tablet and Mobile', 'easy-elementor-addons'),
                    'all' => esc_html__('All Devices', 'easy-elementor-addons'),
                ],
                'render_type' => 'template',
                'condition' => [
                    'title!' => '',
                    'collapsible' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'toggle_icon', [
                'label' => esc_html__('Toggle Icon', 'easy-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'title!' => '',
                    'collapsible' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'highlight_active', [
                'label' => esc_html__('Highlight Current Section', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'reading_progress', [
                'label' => esc_html__('Reading Progress Bar', 'easy-elementor-addons'),
                'description' => esc_html__('A thin line under the title that fills as visitors read through the content.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_control(
            'smooth_scroll', [
                'label' => esc_html__('Smooth Scroll', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'scroll_offset', [
                'label' => esc_html__('Scroll Offset', 'easy-elementor-addons'),
                'description' => esc_html__('Space left above a heading after jumping to it, for example the height of a fixed header.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 300]],
                'default' => ['size' => 24],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'sticky', [
                'label' => esc_html__('Sticky', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'eead-toc-sticky-',
                'description' => esc_html__('Stays in view while the column it sits in scrolls past.', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'sticky_top', [
                'label' => esc_html__('Distance From Top', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 300]],
                'default' => ['size' => 24],
                'selectors' => [
                    '{{WRAPPER}}' => '--eead-toc-sticky-top: {{SIZE}}px',
                ],
                'condition' => [
                    'sticky' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'max_height', [
                'label' => esc_html__('Max List Height', 'easy-elementor-addons'),
                'description' => esc_html__('Longer lists scroll inside the box.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 100, 'max' => 1200],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-body' => 'max-height: {{SIZE}}{{UNIT}}; overflow-y: auto',
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Box */
        $this->start_controls_section(
            'section_style_box', [
                'label' => esc_html__('Box', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'design', [
                'label' => esc_html__('Design', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'card',
                'options' => [
                    'card' => esc_html__('Card', 'easy-elementor-addons'),
                    'simple' => esc_html__('Simple', 'easy-elementor-addons'),
                    'bold' => esc_html__('Bold', 'easy-elementor-addons'),
                    'professional' => esc_html__('Professional', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('A starting look. Every color and spacing below can still be changed.', 'easy-elementor-addons'),
                'prefix_class' => 'eead-toc-design-',
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'box_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .eead-toc'
            ]
        );

        $this->add_responsive_control(
            'box_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_padding', [
                'label' => esc_html__('List Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .eead-toc'
            ]
        );

        $this->end_controls_section();

        /* Style: Title */
        $this->start_controls_section(
            'section_style_title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-toc-title'
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => esc_html__('Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-header, {{WRAPPER}} .eead-toc-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_bg', [
                'label' => esc_html__('Background Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-header' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'title_padding', [
                'label' => esc_html__('Padding', 'easy-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'title_separator_color', [
                'label' => esc_html__('Separator Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-header' => 'border-bottom-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'progress_color', [
                'label' => esc_html__('Progress Bar Color', 'easy-elementor-addons'),
                'description' => esc_html__('Uses the current-item indicator color when empty.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-progress span' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'reading_progress' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'toggle_color', [
                'label' => esc_html__('Toggle Icon Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-toggle-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .eead-toc-toggle-icon svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'collapsible' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: List */
        $this->start_controls_section(
            'section_style_list', [
                'label' => esc_html__('List', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'list_typography',
                'selector' => '{{WRAPPER}} .eead-toc-list a'
            ]
        );

        $this->add_responsive_control(
            'item_spacing', [
                'label' => esc_html__('Space Between Items', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list' => '--eead-toc-gap: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'indent', [
                'label' => esc_html__('Nested Indent', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list' => '--eead-toc-indent: {{SIZE}}px',
                ],
                'condition' => [
                    'hierarchical' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('list_tabs');

        $this->start_controls_tab(
            'list_normal', [
                'label' => esc_html__('Normal', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'list_color', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'marker_color', [
                'label' => esc_html__('Marker Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list' => '--eead-toc-marker: {{VALUE}}',
                ],
                'condition' => [
                    'marker!' => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_hover', [
                'label' => esc_html__('Hover', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'list_color_hover', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list a:hover, {{WRAPPER}} .eead-toc-list a:focus-visible' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_active', [
                'label' => esc_html__('Current', 'easy-elementor-addons'),
                'condition' => [
                    'highlight_active' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'list_color_active', [
                'label' => esc_html__('Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list a.eead-toc-active' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'highlight_active' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'list_indicator', [
                'label' => esc_html__('Indicator Color', 'easy-elementor-addons'),
                'description' => esc_html__('The bar beside the current item.', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc' => '--eead-toc-indicator: {{VALUE}}',
                ],
                'condition' => [
                    'highlight_active' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'list_active_weight', [
                'label' => esc_html__('Bold Current Item', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .eead-toc-list a.eead-toc-active' => 'font-weight: 700',
                ],
                'condition' => [
                    'highlight_active' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $levels = array_values(array_intersect((array) $settings['headings'], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']));
        $has_title = '' !== trim((string) $settings['title']);
        $collapsible = $has_title && 'yes' === $settings['collapsible'];
        $collapsed = $collapsible ? $settings['collapsed'] : 'none';
        $body_id = 'eead-toc-' . $this->get_id();

        $offset = [];
        foreach (['', '_tablet', '_mobile'] as $device) {
            if (isset($settings['scroll_offset' . $device]['size']) && '' !== $settings['scroll_offset' . $device]['size']) {
                $offset[ltrim($device, '_') ?: 'desktop'] = (int) $settings['scroll_offset' . $device]['size'];
            }
        }

        $this->add_render_attribute('toc', [
            'class' => array_filter(['eead-toc', 'eead-toc-collapse-' . $collapsed, 'none' !== $collapsed ? 'eead-toc-start-collapsed' : '']),
            'data-settings' => wp_json_encode([
                'headings' => $levels ?: ['h2', 'h3'],
                'container' => (string) $settings['container'],
                'exclude' => (string) $settings['exclude'],
                'min' => max(1, (int) $settings['min_headings']),
                'nested' => 'yes' === $settings['hierarchical'],
                'highlight' => 'yes' === $settings['highlight_active'],
                'progress' => $has_title && 'yes' === $settings['reading_progress'],
                'smooth' => 'yes' === $settings['smooth_scroll'],
                'offset' => $offset,
                'collapsed' => $collapsed,
                'empty' => esc_html__('No headings found on this page yet. Add some headings, or check the Include Headings and Look Inside settings.', 'easy-elementor-addons'),
            ]),
        ]);
        ?>
        <nav <?php $this->print_render_attribute_string('toc'); ?> aria-label="<?php echo esc_attr($has_title ? $settings['title'] : __('Table of contents', 'easy-elementor-addons')); ?>">
            <?php if ($has_title) { ?>
                <div class="eead-toc-header">
                    <<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'], 'div')); ?> class="eead-toc-title"><?php echo esc_html($settings['title']); ?></<?php echo esc_attr(eead_check_allowed_html_tags($settings['title_tag'], 'div')); ?>>
                    <?php if ($collapsible) { ?>
                        <button type="button" class="eead-toc-toggle" aria-expanded="true" aria-controls="<?php echo esc_attr($body_id); ?>" aria-label="<?php esc_attr_e('Show or hide the table of contents', 'easy-elementor-addons'); ?>">
                            <span class="eead-toc-toggle-icon"><?php Icons_Manager::render_icon($settings['toggle_icon'], ['aria-hidden' => 'true']); ?></span>
                        </button>
                    <?php } ?>
                </div>
                <?php if ('yes' === $settings['reading_progress']) { ?>
                    <div class="eead-toc-progress" aria-hidden="true"><span></span></div>
                <?php } ?>
            <?php } ?>
            <div class="eead-toc-body" id="<?php echo esc_attr($body_id); ?>">
                <div class="eead-toc-list"></div>
                <?php if ('icon' === $settings['marker'] && !empty($settings['marker_icon']['value'])) { ?>
                    <template class="eead-toc-marker-tpl"><span class="eead-toc-icon-marker" aria-hidden="true"><?php Icons_Manager::render_icon($settings['marker_icon'], ['aria-hidden' => 'true']); ?></span></template>
                <?php } ?>
            </div>
        </nav>
        <?php
    }

}
