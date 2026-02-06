<?php

namespace EasyElementorAddons\Modules\PopupModal\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class PopupModal extends Widget_Base {

	public function get_name() {
		return 'eead-popup-modal';
	}

	public function get_title() {
		return esc_html__('Popup Modal', 'easy-elementor-addons');
	}

	public function get_icon() {
		return 'eead-element-icon eead-icons-popup';
	}

	public function get_categories() {
		return ['easy-elementor-addons'];
	}

	public function get_style_depends() {
		return ['micromodal', 'mcustomscrollbar'];
	}

	public function get_script_depends() {
		return ['micromodal', 'mcustomscrollbar'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content', [
				'label' => esc_html__('Content', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'title', [
				'label' => esc_html__('Title', 'easy-elementor-addons'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Modal Title', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'popup_type', [
				'label' => esc_html__('Type', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__('Image', 'easy-elementor-addons'),
					'content' => esc_html__('Content', 'easy-elementor-addons'),
					'template' => esc_html__('Saved Templates', 'easy-elementor-addons'),
					'custom-html' => esc_html__('Custom HTML', 'easy-elementor-addons'),
				],
				'default' => 'image'
			]
		);

		$this->add_control(
			'image', [
				'label' => esc_html__('Choose Image', 'easy-elementor-addons'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'popup_type' => 'image',
				]
			]
		);

		$this->add_control(
			'content', [
				'label' => esc_html__('Content', 'easy-elementor-addons'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
				'condition' => [
					'popup_type' => 'content',
				]
			]
		);

		$this->add_control(
			'templates', [
				'label' => esc_html__('Select Template', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => get_elementor_templates(),
				'label_block' => false,
				'condition' => [
					'popup_type' => 'template',
				]
			]
		);

		$this->add_control(
			'custom_html', [
				'label' => esc_html__('Custom HTML', 'easy-elementor-addons'),
				'type' => Controls_Manager::CODE,
				'language' => 'html',
				'condition' => [
					'popup_type' => 'custom-html',
				]
			]
		);

		$this->add_control(
			'popup_title', [
				'label' => esc_html__('Show Header Title', 'easy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'close_button', [
				'label' => esc_html__('Show Close Button', 'easy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_trigger', [
				'label' => esc_html__('Trigger', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'trigger_type', [
				'label' => esc_html__('Trigger Type', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__('Button', 'easy-elementor-addons'),
					'image' => esc_html__('Image', 'easy-elementor-addons'),
					'icon' => esc_html__('Icon', 'easy-elementor-addons'),
                    'selector' => esc_html__('Selector', 'easy-elementor-addons'),
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trigger_text', [
				'label' => esc_html__('Button Text', 'easy-elementor-addons'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Click Here', 'easy-elementor-addons'),
				'condition' => [
					'trigger_type' => ['button', 'text']
				]
			]
		);

		$this->add_control(
			'trigger_icon', [
				'label' => esc_html__('Button Icon', 'easy-elementor-addons'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'icofont-search',
					'library' => 'iconfont'
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'trigger_type' => ['button', 'icon']
				]
			]
		);

		$this->add_control(
			'trigger_image', [
				'label' => esc_html__('Trigger Image', 'easy-elementor-addons'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'trigger_type' => 'image'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(), [
				'name' => 'trigger_image_thumbnail',
				'exclude' => ['custom'],
				'include' => [],
				'default' => 'full',
				'condition' => [
					'trigger_type' => 'image'
				]
			]
		);

		$this->add_control(
			'enable_image_trigger_icon', [
				'label' => esc_html__('Show Trigger Icon', 'easy-elementor-addons'),
				'description' => esc_html__('Display at the center of the image', 'easy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'trigger_type' => 'image',
				]
			]
		);

		$this->add_control(
			'image_trigger_icon', [
				'label' => esc_html__('Trigger Icon', 'easy-elementor-addons'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'icofont-search',
					'library' => 'iconfont'
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'trigger_type' => 'image',
					'enable_image_trigger_icon' => 'yes'
				]
			]
		);

		$this->add_control(
			'icon_align', [
				'label' => esc_html__('Icon Position', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row' => esc_html__('Before', 'easy-elementor-addons'),
					'row-reverse' => esc_html__('After', 'easy-elementor-addons'),
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger .eead-popup-modal-trigger-button' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'trigger_type' => ['button']
				]
			]
		);

        $this->add_control(
            'trigger_selector', [
                'label' => esc_html__('Selector', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => esc_html__('#id or .class of element, or element for selecting element.', 'easy-elementor-addons'),
                'condition' => [
                    'trigger_type' => 'selector'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout', [
				'label' => esc_html__('Layout', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'layout_type', [
				'label' => esc_html__('Layout', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'standard' => esc_html__('Standard', 'easy-elementor-addons'),
					'fullscreen' => esc_html__('Fullscreen', 'easy-elementor-addons'),
				],
				'default' => 'standard'
			]
		);

		$this->add_responsive_control(
			'popup_width', [
				'label' => esc_html__('Width', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '850',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1600,
						'step' => 1,
					]
				],
				'size_units' => ['px', '%', 'vw'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;',
				],
				'condition' => [
					'layout_type' => 'standard',
				]
			]
		);

		$this->add_responsive_control(
			'popup_height', [
				'label' => esc_html__('Max Height', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '90',
					'unit' => 'vh',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1600,
						'step' => 1,
					]
				],
				'size_units' => ['px', '%', 'vh'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container' => 'max-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_type' => 'standard',
				]
			]
		);

		$this->add_control(
			'popup_animation', [
				'label' => esc_html__('Popup Animation', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'fadeIn',
				'options' => eead_show_animations()
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style', [
				'label' => esc_html__('Trigger Image', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trigger_type' => ['image']
				]
			]
		);

		$this->add_control(
			'trigger_image_width', [
				'label' => esc_html__('Image Max Width', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1200,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-image' => 'max-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'trigger_image_border',
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
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-image'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'trigger_image_shadow',
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-image'
			]
		);

		$this->add_responsive_control(
			'trigger_image_border_radius', [
				'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'trigger_icon_size', [
				'label' => esc_html__('Trigger Icon Size', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					]
				],
				'default' => [
					'size' => 40,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-image span i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eead-popup-modal-trigger-image span svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_image_trigger_icon' => 'yes'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trigger_icon_color', [
				'label' => esc_html__('Trigger Icon Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFF',
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-image span i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eead-popup-modal-trigger-image span svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'enable_image_trigger_icon' => 'yes'
				]
			]
		);

		$this->add_control(
			'overlay_color', [
				'label' => esc_html__('Image Overlay Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.2)',
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-image span' => 'background: {{VALUE}};',
				],
				'condition' => [
					'enable_image_trigger_icon' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style', [
				'label' => esc_html__('Trigger Icon', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trigger_type' => ['icon']
				]
			]
		);

		$this->add_control(
			'icon_style', [
				'label' => esc_html__('Icon Style', 'easy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'label_block' => false,
				'options' => [
					'default' => esc_html__('Default', 'easy-elementor-addons'),
					'framed' => esc_html__('Framed', 'easy-elementor-addons'),
					'stacked' => esc_html__('Stacked', 'easy-elementor-addons'),
				]
			]
		);

		$this->add_control(
			'icon_color', [
				'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eead-popup-modal-trigger-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .eead-popup-modal-trigger-icon.eead-popup-modal-trigger-icon-framed' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'icon_bg_color', [
				'label' => esc_html__('Background Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '#F1E2FF',
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon.eead-popup-modal-trigger-icon-stacked' => 'background: {{VALUE}};',
				],
				'condition' => [
					'icon_style' => 'stacked',
				]
			]
		);

		$this->add_responsive_control(
			'icon_size', [
				'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 24,
				],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 250,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eead-popup-modal-trigger-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				]
			]
		);

		$this->add_responsive_control(
			'icon_circle_size', [
				'label' => esc_html__('Icon Outer Size', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 70,
				],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'icon_border_width', [
				'label' => esc_html__('Border Width', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_style' => 'framed',
				]
			]
		);

		$this->add_control(
			'icon_radius_advanced_show', [
				'label' => esc_html__('Advanced Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'icon_style!' => 'default',
				]
			]
		);

		$this->add_control(
			'icon_radius', [
				'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'icon_style!' => 'default',
					'icon_radius_advanced_show!' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon_radius_advanced', [
				'label' => esc_html__('Radius', 'easy-elementor-addons'),
				/* translators: 1: border radius, 2: link. */
				'description' => sprintf(__('For example: <b>%1$s</b> or Go <a href="%2$s" target="_blank">this link</a> and copy and paste the radius value.', 'easy-elementor-addons'), '75% 25% 43% 57% / 46% 29% 71% 54%', 'https://9elements.github.io/fancy-border-radius/'),
				'type' => Controls_Manager::TEXT,
				'default' => '75% 25% 43% 57% / 46% 29% 71% 54%',
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-icon' => 'border-radius: {{VALUE}};'
				],
				'condition' => [
					'icon_style!' => 'default',
					'icon_radius_advanced_show' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style', [
				'label' => esc_html__('Trigger Button', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trigger_type' => ['button']
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button'
			]
		);

		$this->add_control(
			'icon_indent', [
				'label' => esc_html__('Icon Spacing', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					]
				],
				'default' => [
					'size' => 8,
				],
				'condition' => [
					'trigger_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button' => 'gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'button_padding', [
				'label' => esc_html__('Padding', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'button_radius', [
				'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal', [
				'label' => esc_html__('Normal', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'button_text_color', [
				'label' => esc_html__('Text Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'name' => 'button_background',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'button_border',
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
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'button_shadow',
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover', [
				'label' => esc_html__('Hover', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'button_text_color_hover', [
				'label' => esc_html__('Text Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'name' => 'button_background_hover',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button:hover'
			]
		);

		$this->add_control(
			'button_border_color_hover', [
				'label' => esc_html__('Border Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal-trigger-button:hover' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'button_shadow_hover',
				'selector' => '{{WRAPPER}} .eead-popup-modal-trigger-button:hover'
			]
		);

		$this->add_control(
			'button_hover_animation', [
				'label' => esc_html__('Hover Animation', 'easy-elementor-addons'),
				'type' => Controls_Manager::HOVER_ANIMATION
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_window_style', [
				'label' => esc_html__('Popup Box', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'name' => 'popup_bg',
				'label' => esc_html__('Background', 'easy-elementor-addons'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__container'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'popup_border',
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
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__container'
			]
		);

		$this->add_responsive_control(
			'popup_border_radius', [
				'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'popup_padding', [
				'label' => esc_html__('Padding', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(), [
				'name' => 'popup_box_shadow',
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__container',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_overlay_style', [
				'label' => esc_html__('Popup Overlay', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'show_overlay', [
				'label' => esc_html__('Overlay', 'easy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'name' => 'overlay_bg',
				'types' => array('classic', 'gradient'),
				'exclude' => array('image'),
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__overlay',
				'condition' => [
					'show_overlay' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style', [
				'label' => esc_html__('Popup Title', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'popup_title' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'title_align', [
				'label' => esc_html__('Alignment', 'easy-elementor-addons'),
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
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__header' => 'justify-content: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_bg', [
				'label' => esc_html__('Background Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__header' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'title_color', [
				'label' => esc_html__('Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'popup_title' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'title_typography',
				'label' => esc_html__('Typography', 'easy-elementor-addons'),
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__title'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'title_border',
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
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__header'
			]
		);

		$this->add_responsive_control(
			'title_padding', [
				'label' => esc_html__('Padding', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'title_margin', [
				'label' => esc_html__('Margin', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_content_style', [
				'label' => esc_html__('Content', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'content_align', [
				'label' => esc_html__('Alignment', 'easy-elementor-addons'),
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
					],
					'justify' => [
						'title' => esc_html__('Justified', 'easy-elementor-addons'),
						'icon' => 'eicon-text-align-justify',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__content' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'popup_type' => 'content',
				]
			]
		);

		$this->add_control(
			'content_text_color', [
				'label' => esc_html__('Text Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__content' => 'color: {{VALUE}}',
				],
				'condition' => [
					'popup_type' => 'content',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'content_typography',
				'label' => esc_html__('Typography', 'easy-elementor-addons'),
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__content',
				'condition' => [
					'popup_type' => 'content',
				]
			]
		);

		$this->add_responsive_control(
			'content_margin', [
				'label' => esc_html__('Margin', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_close_button_style', [
				'label' => esc_html__('Popup Close Button', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'close_button' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'close_button_align', [
				'label' => esc_html__('Position', 'easy-elementor-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'easy-elementor-addons'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__('Right', 'easy-elementor-addons'),
						'icon' => 'eicon-h-align-right',
					]
				],
				'toggle' => false,
				'default' => 'right'
			]
		);

		$this->add_responsive_control(
			'close_button_offset_top', [
				'label' => esc_html__('Top Offset', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .eead-popup-modal-close' => 'top: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'close_button_offset_left', [
				'label' => esc_html__('Left Offset', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .eead-popup-modal-close' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_button_align' => 'left',
				]
			]
		);

		$this->add_responsive_control(
			'close_button_offset_right', [
				'label' => esc_html__('Right Offset', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '20',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .eead-popup-modal-close' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_button_align' => 'right',
				]
			]
		);

		$this->add_responsive_control(
			'close_button_size', [
				'label' => esc_html__('Button Size', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '50',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
						'step' => 1,
					]
				],
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->add_responsive_control(
			'close_button_icon_size', [
				'label' => esc_html__('Icon Size', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '28',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
						'step' => 1,
					]
				],
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close span' => 'font-size: {{SIZE}}{{UNIT}}',
				]
			]
		);

		$this->start_controls_tabs('tabs_close_button_style');

		$this->start_controls_tab(
			'tab_close_button_normal', [
				'label' => esc_html__('Normal', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'close_button_color_normal', [
				'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close span' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'close_button_bg', [
				'label' => esc_html__('Background Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close' => 'background: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'close_button_border_normal',
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
				'selector' => '{{WRAPPER}} .eead-popup-modal .modal__close'
			]
		);

		$this->add_responsive_control(
			'close_button_border_radius', [
				'label' => esc_html__('Border Radius', 'easy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_close_button_hover', [
				'label' => esc_html__('Hover', 'easy-elementor-addons')
			]
		);

		$this->add_control(
			'close_button_color_hover', [
				'label' => esc_html__('Icon Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close:hover span' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'close_button_bg_hover', [
				'label' => esc_html__('Background Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close:hover' => 'background: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'close_button_border_hover', [
				'label' => esc_html__('Border Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__close:hover' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'scroll_bar_style', [
				'label' => esc_html__('Popup Scroll Bar', 'easy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'scrollbar_width', [
				'label' => esc_html__('Track Width', 'easy-elementor-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '3',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
						'step' => 1,
					]
				],
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container::-webkit-scrollbar' => 'width: {{SIZE}}{{UNIT}}',
				]
			]
		);


		$this->add_control(
			'scrollbar_track_color', [
				'label' => esc_html__('Track Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container::-webkit-scrollbar-track' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'scrollbar_thumb_color', [
				'label' => esc_html__('Thumb Color', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'scrollbar_thumb_hover_color', [
				'label' => esc_html__('Thumb Color (Hover)', 'easy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eead-popup-modal .modal__container::-webkit-scrollbar-thumb:hover' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render_button() {
		$settings = $this->get_settings_for_display();
		$id = $this->get_id();

		$this->add_render_attribute('popup-modal-button', [
			'href' => '#',
			'class' => [
				'eead-popup-modal-trigger-btn',
				esc_attr('eead-popup-modal-trigger-' . $settings['trigger_type']),
				esc_attr('eead-modal-popup-btn-' . $id)
			],
			'data-id' => esc_attr($id)
		]);

		if ($settings['trigger_type'] == 'selector') {
			$this->add_render_attribute('popup-modal-button', 'data-selector', $settings['trigger_selector']);
		}

		if ($settings['button_hover_animation']) {
			$this->add_render_attribute('popup-modal-button', 'class', 'elementor-animation-' . esc_attr($settings['button_hover_animation']));
		}

		if ($settings['trigger_type'] == 'icon') {
			$this->add_render_attribute('popup-modal-button', 'class', 'eead-popup-modal-trigger-icon-' . esc_attr($settings['icon_style']));
		}
		?>

		<a <?php $this->print_render_attribute_string('popup-modal-button'); ?>>
			<?php
			if ($settings['trigger_type'] == 'button') {
				if (!empty($settings['trigger_icon']['value'])) {
					Icons_Manager::render_icon($settings['trigger_icon'], ['aria-hidden' => 'true']);
				}
				echo '<span>' . esc_html($settings['trigger_text']) . '</span>';
			} elseif ($settings['trigger_type'] == 'image') {
				echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings, 'trigger_image_thumbnail', 'trigger_image'));
				if ($settings['enable_image_trigger_icon']) {
					echo '<span>';
					Icons_Manager::render_icon($settings['image_trigger_icon'], ['aria-hidden' => 'true']);
					echo '</span>';
				}
			} elseif ($settings['trigger_type'] == 'text') {
				echo '<span>' . esc_html($settings['trigger_text']) . '</span>';
			} elseif ($settings['trigger_type'] == 'icon') {
				Icons_Manager::render_icon($settings['trigger_icon'], ['aria-hidden' => 'true']);
			}
			?>
		</a>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id = $this->get_id();
		$overlay = $settings['show_overlay'] ? 'yes' : 'no';

		$this->add_render_attribute('popup-modal', [
			'id' => esc_attr('eead-popup-modal-' . $id),
			'class' => [
				'eead-popup-modal',
				'eead-popup-modal-' . esc_attr($settings['layout_type']),
				'eead-popup-modal-overlay-' . esc_attr($overlay)
			],
			'aria-hidden' => "true"
		]);
		?>
		<div class="eead-popup-modal-trigger">
			<?php $this->render_button(); ?>
		</div>

		<div <?php $this->print_render_attribute_string('popup-modal'); ?>>
			<div class="modal__overlay" tabindex="-1" data-micromodal-close>
				<div class="modal__container animated animated-fast <?php echo esc_attr($settings['popup_animation']) ?>" role="dialog" aria-modal="true" aria-labelledby="modal-<?php echo esc_attr($id); ?>-title">
					<?php if ($settings['close_button'] == 'yes') { ?>
						<div class="eead-popup-modal-close">
							<button class="modal__close" aria-label="<?php echo esc_html__('Close Modal', 'easy-elementor-addons'); ?>" data-micromodal-close>
								<span class="icofont-close-line" data-micromodal-close></span>
							</button>
						</div>
					<?php } ?>

					<?php if ($settings['popup_title'] == 'yes' && !empty($settings['title'])) { ?>
						<header class="modal__header">
							<h2 class="modal__title" id="modal-<?php echo esc_attr($id); ?>-title">
								<?php echo esc_html($settings['title']); ?>
							</h2>
						</header>
					<?php } ?>

					<div class="modal__content" id="modal-<?php echo esc_attr($id); ?>-content">
						<?php
						switch ($settings['popup_type']) {
							case 'image':
								echo '<img src="' . esc_url($settings['image']['url']) . '">';
								break;

							case 'content':
								global $wp_embed;
								$content = wpautop($wp_embed->autoembed($settings['content']));
								echo do_shortcode($content);
								break;

							case 'template':
								$template_id = $settings['templates'];
								echo Plugin::$instance->frontend->get_builder_content_for_display($template_id);
								break;

							case 'custom-html':
								echo wp_kses_post($settings['custom_html']);
								break;

							default:
								echo '';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}
