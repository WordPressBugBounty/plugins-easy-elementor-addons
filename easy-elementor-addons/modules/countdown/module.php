<?php

namespace EasyElementorAddons\Modules\Countdown;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-countdown';
    }

    public function get_widgets() {
        $widgets = [
            'Countdown',
        ];
        return $widgets;
    }

}
