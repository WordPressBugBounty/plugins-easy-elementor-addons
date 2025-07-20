<?php

namespace EasyElementorAddons\Modules\Progressbar;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-progressbar';
    }

    public function get_widgets() {
        $widgets = [
            'Progressbar',
        ];
        return $widgets;
    }

}
