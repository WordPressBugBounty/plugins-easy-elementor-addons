<?php

namespace EasyElementorAddons\Modules\AdvancedIconBox;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-advanced-icon-box';
    }

    public function get_widgets() {
        $widgets = [
            'AdvancedIconBox',
        ];
        return $widgets;
    }

}
