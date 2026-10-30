<?php

namespace EasyElementorAddons\Modules\ImageStack;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-image-stack';
    }

    public function get_widgets() {
        $widgets = [
            'ImageStack',
        ];
        return $widgets;
    }

}
