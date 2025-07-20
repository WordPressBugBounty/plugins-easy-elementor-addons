<?php

namespace EasyElementorAddons\Modules\AnimatedHeading\Widgets;

// Elementor Classes
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Animated Heading Widget
 */
class AnimatedHeading extends Widget_Base {

    public function get_name() {
        return 'eead-animated-heading';
    }

    public function get_title() {
        return esc_html__('Animated Heading', 'easy-elementor-addons');
    }

    public function get_icon() {
        return 'eead-element-icon eead-icons-animated-heading';
    }

    public function get_categories() {
        return ['easy-elementor-addons'];
    }

    public function get_script_depends() {
        return ['morphext', 'typed'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'header_content', [
                'label' => esc_html__('Header Contents', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'pre_heading', [
                'label' => esc_html__('Pre Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'default' => esc_html__('Hello I am', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Type your pre heading here.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'animated_heading', [
                'label' => esc_html__('Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'default' => esc_html__('Animated,Morphing,Awesome.', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Type your text here.', 'easy-elementor-addons'),
                'description' => esc_html__('Write animated heading here with comma separated. Such as Animated, Morphing, Awesome', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'post_heading', [
                'label' => esc_html__('Post Heading', 'easy-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'default' => esc_html__('Heading', 'easy-elementor-addons'),
                'placeholder' => esc_html__('Please type the post heading here.', 'easy-elementor-addons')
            ]
        );

        $this->add_control(
            'heading_link', [
                'label' => esc_html__('Link', 'easy-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ]
            ]
        );

        $this->add_control(
            'layout', [
                'label' => esc_html__('Layout', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'typed' => esc_html__('Typed', 'easy-elementor-addons'),
                    'animated' => esc_html__('Animated', 'easy-elementor-addons')
                ],
                'default' => 'animated'
            ]
        );

        $this->add_control(
            'alignment', [
                'label' => esc_html__('Alignment', 'easy-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
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
                'selectors' => [
                    '{{WRAPPER}} .eead-ah-heading' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'html_tag', [
                'label' => esc_html__('HTML Tag', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => eead_html_tags(),
                'default' => 'h3'
            ]
        );

        $this->end_controls_section();

        /* Animation Settings */
        $this->start_controls_section(
            'animation_settings', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'condition' => [
                    'layout' => ['animated'],
                ]
            ]
        );

        $this->add_control(
            'heading_animation', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'type' => Controls_Manager::ANIMATION,
                'default' => 'fadeIn',
                'label_block' => true,
                'condition' => [
                    'heading_animation!' => '',
                    'layout' => 'animated',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'heading_animation_duration', [
                'label' => esc_html__('Animation Duration', 'easy-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '' => esc_html__('Normal', 'easy-elementor-addons'),
                    'slow' => esc_html__('Slow', 'easy-elementor-addons'),
                    'fast' => esc_html__('Fast', 'easy-elementor-addons'),
                ],
                'condition' => [
                    'heading_animation!' => '',
                    'layout' => 'animated',
                ]
            ]
        );

        $this->add_control(
            'heading_animation_delay', [
                'label' => esc_html__('Animation Delay (ms)', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2500,
                'min' => 100,
                'max' => 9000,
                'step' => 100,
                'condition' => [
                    'heading_animation!' => '',
                    'layout' => 'animated',
                ]
            ]
        );

        $this->end_controls_section();

        /* Typed Heading Settings */
        $this->start_controls_section(
            'typed_settings', [
                'label' => esc_html__('Animation', 'easy-elementor-addons'),
                'condition' => [
                    'layout' => ['typed'],
                ]
            ]
        );

        $this->add_control(
            'type_speed', [
                'label' => esc_html__('Type Speed', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 60,
                'min' => 10,
                'max' => 100,
                'step' => 5
            ]
        );

        $this->add_control(
            'start_delay', [
                'label' => esc_html__('Start Delay', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 100,
                'step' => 1
            ]
        );

        $this->add_control(
            'back_speed', [
                'label' => esc_html__('Back Speed', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 0,
                'max' => 100,
                'step' => 2
            ]
        );

        $this->add_control(
            'back_delay', [
                'label' => esc_html__('Back Delay', 'easy-elementor-addons') . ' (ms)',
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'min' => 0,
                'max' => 3000,
                'step' => 50
            ]
        );

        $this->add_control(
            'infinite_loop', [
                'label' => esc_html__('Infinite Loop', 'easy-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'loop_count', [
                'label' => esc_html__('Loop Count', 'easy-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 1,
                'condition' => [
                    'infinite_loop!' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'text_style', [
                'label' => esc_html__('Text', 'easy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'text_color', [
                'label' => esc_html__('Pre/Post Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-ah-heading .eead-ah-pre-heading,
                 {{WRAPPER}} .eead-ah-heading .eead-ah-post-heading' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'animated_text_color', [
                'label' => esc_html__('Animated Text Color', 'easy-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .eead-ah-heading .eead-animated-heading, {{WRAPPER}} .eead-ah-heading .typed-cursor' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'easy-elementor-addons'),
                'selector' => '{{WRAPPER}} .eead-ah-heading'
            ]
        );

        $this->end_controls_section();
    }

    /** Render Layout */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $type_heading = explode(",", esc_html($settings['animated_heading']));
        $html_tag = $settings['html_tag'];

        $this->add_render_attribute([
            'animated-heading' => [
                'id' => esc_attr('eead-animated-heading-' . $id),
                'class' => 'eead-animated-heading'
            ]
        ]);

        if ($settings['layout'] == 'animated') {
            if ($settings['heading_animation_duration']) {
                $this->add_render_attribute('animated-heading', 'class', ' eead-animated-' . $settings['heading_animation_duration']);
            }
            $this->add_render_attribute([
                'animated-heading' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'layout' => $settings['layout'],
                            'animation' => $settings['heading_animation'],
                            'speed' => $settings['heading_animation_delay'],
                        ]))
                    ]
                ]
            ]);
        } elseif ($settings['layout'] == 'typed') {
            $this->add_render_attribute([
                'animated-heading' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'layout' => $settings['layout'],
                            'strings' => array_merge([''], $type_heading),
                            'typeSpeed' => $settings['type_speed'],
                            'startDelay' => $settings['start_delay'],
                            'backSpeed' => $settings['back_speed'],
                            'backDelay' => $settings['back_delay'],
                            'loop' => $settings['infinite_loop'] == 'yes' ? true : false,
                            'loopCount' => $settings['infinite_loop'] == 'yes' ? false : $settings['loop_count'],
                        ]))
                    ]
                ]
            ]);
        }
        ?>

        <<?php echo esc_attr(eead_check_allowed_html_tags($html_tag)); ?> class="eead-ah-heading">

            <?php
            if (!empty($settings['heading_link']['url'])) {
                $this->add_render_attribute('url', 'href', esc_url($settings['heading_link']['url']));
                if ($settings['heading_link']['is_external']) {
                    $this->add_render_attribute('url', 'target', '_blank');
                }

                if (!empty($settings['heading_link']['nofollow'])) {
                    $this->add_render_attribute('url', 'rel', 'nofollow');
                }
                echo sprintf('<a %1$s>', $this->get_render_attribute_string('url'));
            }

            if ($settings['pre_heading']) {
                ?>
                <span class="eead-ah-pre-heading">
                    <?php echo esc_html($settings['pre_heading']); ?>
                </span>
                <?php
            }

            if ($settings['animated_heading']) {
                ?>
                <span <?php $this->print_render_attribute_string('animated-heading'); ?>>
                    <?php
                    if ($settings['layout'] != 'typed') {
                        echo rtrim(esc_attr($settings['animated_heading']), ',');
                    }
                    ?>
                </span>
                <?php
            }

            if ($settings['post_heading']) {
                ?>
                <span class="eead-ah-post-heading">
                    <?php echo esc_html($settings['post_heading']); ?>
                </span>
                <?php
            }

            if (!empty($settings['heading_link']['url'])) {
                echo '</a>';
            }
            ?>

        </<?php echo esc_attr(eead_check_allowed_html_tags($html_tag)); ?>>
        <?php
    }

}
