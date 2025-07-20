<?php

namespace EasyElementorAddons\Modules\BusinessHour;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-business-hour';
    }

    public function get_widgets() {
        $widgets = [
            'BusinessHour',
        ];
        return $widgets;
    }

}
