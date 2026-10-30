<?php

namespace EasyElementorAddons\Modules\AppearingImage;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-appearing-image';
    }

    public function get_widgets() {
        $widgets = [
            'AppearingImage',
        ];
        return $widgets;
    }

}
