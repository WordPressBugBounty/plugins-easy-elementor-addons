<?php

namespace EasyElementorAddons\Modules\Hotspot;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-hotspot';
    }

    public function get_widgets() {
        $widgets = [
            'Hotspot',
        ];
        return $widgets;
    }

}
