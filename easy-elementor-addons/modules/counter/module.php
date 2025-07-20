<?php

namespace EasyElementorAddons\Modules\Counter;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-counter';
    }

    public function get_widgets() {
        $widgets = [
            'Counter',
        ];
        return $widgets;
    }

}
