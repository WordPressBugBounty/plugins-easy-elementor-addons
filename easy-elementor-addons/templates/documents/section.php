<?php

namespace EEADElements\Templates\Documents;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class EEAD_Section_Document extends EEAD_Document_Base {

    public function get_name() {
        return 'eead';
    }

    public static function get_title() {
        return esc_html__('Section', 'easy-elementor-addons');
    }

    public function has_conditions() {
        return false;
    }

}
