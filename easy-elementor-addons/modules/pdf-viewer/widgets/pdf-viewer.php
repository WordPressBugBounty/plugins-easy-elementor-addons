<?php

namespace EasyElementorAddons\Modules\PdfViewer\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * PDF Viewer Widget
 */
class PdfViewer extends Widget_Base {

    public function get_name() {
        return 'eead-pdf-viewer';
    }

    public function get_title() {
        return esc_html__('PDF Viewer', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-pdf-viewer';
    }

    public function get_keywords() {
        return ['pdf', 'document', 'viewer', 'embed', 'menu', 'brochure', 'download', 'eead'];
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
            'section_pdf', [
                'label' => esc_html__('PDF', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'source', [
                'label' => esc_html__('Source', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'media',
                'options' => [
                    'media' => esc_html__('Media Library', 'easy-elementor-addons'),
                    'url' => esc_html__('Link', 'easy-elementor-addons'),
                ]
            ]
        );

        $this->add_control(
            'file', [
                'label' => esc_html__('PDF File', 'easy-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['application/pdf'],
                'condition' => [
                    'source' => 'media'
                ]
            ]
        );

        $this->add_control(
            'url', [
                'label' => esc_html__('PDF Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://example.com/menu.pdf',
                'description' => esc_html__('The file must allow being shown on other sites. Files on your own site always work.', 'easy-elementor-addons'),
                'condition' => [
                    'source' => 'url'
                ]
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'placeholder' => esc_html__('Uses the file name', 'easy-elementor-addons'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_bar', [
                'label' => esc_html__('Title Bar', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_download', [
                'label' => esc_html__('Download Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'show_bar' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_open', [
                'label' => esc_html__('Open in New Tab Button', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'show_bar' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'start_page', [
                'label' => esc_html__('Start on Page', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 1
            ]
        );

        $this->add_control(
            'browser_toolbar', [
                'label' => esc_html__('Browser\'s PDF Toolbar', 'easy-elementor-addons'),
                'description' => esc_html__('Some browsers ignore this and always show their toolbar.', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'mobile_mode', [
                'label' => esc_html__('On Phones', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'card',
                'options' => [
                    'card' => esc_html__('Show a Button Instead', 'easy-elementor-addons'),
                    'embed' => esc_html__('Embed Anyway', 'easy-elementor-addons'),
                ],
                'description' => esc_html__('Most phone browsers cannot show a PDF inside a page.', 'easy-elementor-addons'),
                'prefix_class' => 'eead-pdfv-mobile-',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'card_text', [
                'label' => esc_html__('Button Text on Phones', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Open the PDF', 'easy-elementor-addons'),
                'condition' => [
                    'mobile_mode' => 'card'
                ]
            ]
        );

        $this->end_controls_section();

        /* Style: Viewer */
        $this->start_controls_section(
            'section_style_viewer', [
                'label' => esc_html__('Viewer', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'height', [
                'label' => esc_html__('Height', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 200, 'max' => 1600],
                    'vh' => ['min' => 20, 'max' => 100],
                ],
                'default' => ['size' => 720, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv-frame' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'viewer_border',
                'selector' => '{{WRAPPER}} .eead-pdfv'
            ]
        );

        $this->add_responsive_control(
            'viewer_radius', [
                'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv' => 'border-radius: {{SIZE}}px',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'viewer_shadow',
                'selector' => '{{WRAPPER}} .eead-pdfv'
            ]
        );

        $this->end_controls_section();

        /* Style: Title Bar */
        $this->start_controls_section(
            'section_style_bar', [
                'label' => esc_html__('Title Bar & Buttons', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'bar_bg', [
                'label' => esc_html__('Bar Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv-bar' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_bar' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'bar_color', [
                'label' => esc_html__('Bar Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv-bar' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_bar' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .eead-pdfv-title',
                'condition' => [
                    'show_bar' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_bg', [
                'label' => esc_html__('Button Background', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'button_color', [
                'label' => esc_html__('Button Text', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eead-pdfv-btn' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

    private function pdf_url($settings) {
        if ('url' === $settings['source']) {
            return !empty($settings['url']['url']) ? $settings['url']['url'] : '';
        }
        if (!empty($settings['file']['id'])) {
            $url = wp_get_attachment_url((int) $settings['file']['id']);
            if ($url) {
                return $url;
            }
        }
        return !empty($settings['file']['url']) ? $settings['file']['url'] : '';
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        // Only web addresses; anything else (javascript:, data:) is dropped.
        $url = esc_url_raw($this->pdf_url($settings), ['http', 'https']);

        if (!$url) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="eead-pdfv-empty">' . esc_html__('Choose a PDF file or enter a link to one.', 'easy-elementor-addons') . '</div>';
            }
            return;
        }

        $title = trim((string) $settings['title']);
        if ('' === $title) {
            $title = wp_basename(wp_parse_url($url, PHP_URL_PATH));
        }

        // Open parameters understood by the browsers' own PDF viewers.
        $params = ['page=' . max(1, (int) $settings['start_page'])];
        if ('yes' !== $settings['browser_toolbar']) {
            $params[] = 'toolbar=0';
        }
        $embed = $url . '#' . implode('&', $params);
        $download_icon = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0-5-5m5 5 5-5M5 21h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        $open_icon = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6m0-6L10 14M19 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        ?>
        <div class="eead-pdfv">
            <?php if ('yes' === $settings['show_bar']) { ?>
                <div class="eead-pdfv-bar">
                    <span class="eead-pdfv-icon" aria-hidden="true">PDF</span>
                    <span class="eead-pdfv-title"><?php echo esc_html($title); ?></span>
                    <span class="eead-pdfv-actions">
                        <?php if ('yes' === $settings['show_open']) { ?>
                            <a class="eead-pdfv-btn eead-pdfv-btn-ghost" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"><?php echo $open_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?><span><?php esc_html_e('Open', 'easy-elementor-addons'); ?></span></a>
                        <?php } ?>
                        <?php if ('yes' === $settings['show_download']) { ?>
                            <a class="eead-pdfv-btn" href="<?php echo esc_url($url); ?>" download><?php echo $download_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?><span><?php esc_html_e('Download', 'easy-elementor-addons'); ?></span></a>
                        <?php } ?>
                    </span>
                </div>
            <?php } ?>
            <iframe class="eead-pdfv-frame" src="<?php echo esc_url($embed); ?>" title="<?php echo esc_attr($title); ?>" loading="lazy"></iframe>
            <div class="eead-pdfv-card">
                <span class="eead-pdfv-card-icon" aria-hidden="true">PDF</span>
                <span class="eead-pdfv-card-title"><?php echo esc_html($title); ?></span>
                <a class="eead-pdfv-btn" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"><?php echo $open_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?><span><?php echo esc_html($settings['card_text'] ?: __('Open the PDF', 'easy-elementor-addons')); ?></span></a>
            </div>
        </div>
        <?php
    }

}
