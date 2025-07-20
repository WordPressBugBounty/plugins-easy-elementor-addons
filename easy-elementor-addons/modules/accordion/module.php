<?php

namespace EasyElementorAddons\Modules\Accordion;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-accordion';
    }

    public function get_widgets() {
        $widgets = [
            'Accordion',
        ];
        return $widgets;
    }

}
