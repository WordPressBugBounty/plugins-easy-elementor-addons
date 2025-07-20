<?php

namespace EasyElementorAddons\Modules\Weather;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-weather';
    }

    public function get_widgets() {
        $widgets = [
            'Weather',
        ];
        return $widgets;
    }

}
