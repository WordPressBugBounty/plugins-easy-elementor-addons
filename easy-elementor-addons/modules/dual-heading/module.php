<?php

namespace EasyElementorAddons\Modules\DualHeading;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-dual-heading';
    }

    public function get_widgets() {
        $widgets = [
            'DualHeading',
        ];
        return $widgets;
    }

}
