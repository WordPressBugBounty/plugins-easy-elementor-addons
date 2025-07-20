<?php

namespace EasyElementorAddons\Modules\CircularProgressbar;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-circular-progressbar';
    }

    public function get_widgets() {
        $widgets = [
            'CircularProgressbar',
        ];
        return $widgets;
    }

}
