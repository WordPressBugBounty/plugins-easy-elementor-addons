<?php

namespace EEADElements\Templates\Types;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists(__NAMESPACE__ . '\EEAD_Structure_Section')) {

    /**
     * Define EEAD_Structure_Section class
     */
    class EEAD_Structure_Section extends EEAD_Structure_Base {

        public function get_id() {
            return 'eead_section';
        }

        public function get_single_label() {
            return esc_html__('Section', 'easy-elementor-addons');
        }

        public function get_plural_label() {
            return esc_html__('Sections', 'easy-elementor-addons');
        }

        public function get_sources() {
            return array('eead');
        }

        /**
         * Library settings for current structure
         *
         * @return void
         */
        public function library_settings() {
            return array(
                'show_title' => true,
                'show_widgets' => true,
            );
        }

    }

}
