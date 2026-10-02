<?php

namespace EEADElements\Templates\Types;

if (!defined('ABSPATH'))
    exit; // No access of directly access

if (!class_exists(__NAMESPACE__ . '\EEAD_Structure_Base')) {

    abstract class EEAD_Structure_Base {

        abstract public function get_id();

        abstract public function get_single_label();

        abstract public function get_plural_label();

        abstract public function get_sources();

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
