<?php

namespace EasyElementorAddons\Modules\Switcher;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-switcher';
    }

    public function get_widgets() {
        $widgets = [
            'Switcher',
        ];
        return $widgets;
    }

}
