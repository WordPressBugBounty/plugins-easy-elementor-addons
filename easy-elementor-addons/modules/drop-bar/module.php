<?php

namespace EasyElementorAddons\Modules\DropBar;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-drop-bar';
    }

    public function get_widgets() {
        $widgets = [
            'DropBar',
        ];
        return $widgets;
    }

}
