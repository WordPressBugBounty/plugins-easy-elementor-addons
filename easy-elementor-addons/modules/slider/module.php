<?php

namespace EasyElementorAddons\Modules\Slider;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-slider';
    }

    public function get_widgets() {
        $widgets = [
            'Slider',
        ];
        return $widgets;
    }

}
