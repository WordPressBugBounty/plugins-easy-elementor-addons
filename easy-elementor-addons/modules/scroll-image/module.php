<?php

namespace EasyElementorAddons\Modules\ScrollImage;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-scroll-image';
    }

    public function get_widgets() {
        $widgets = [
            'ScrollImage',
        ];
        return $widgets;
    }

}
