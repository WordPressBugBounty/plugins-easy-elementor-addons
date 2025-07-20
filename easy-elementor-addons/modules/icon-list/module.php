<?php

namespace EasyElementorAddons\Modules\IconList;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-icon-list';
    }

    public function get_widgets() {
        $widgets = [
            'IconList',
        ];
        return $widgets;
    }

}
