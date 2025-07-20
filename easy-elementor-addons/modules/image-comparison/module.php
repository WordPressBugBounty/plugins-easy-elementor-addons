<?php

namespace EasyElementorAddons\Modules\ImageComparison;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-image-comparison';
    }

    public function get_widgets() {
        $widgets = [
            'ImageComparison',
        ];
        return $widgets;
    }

}
