<?php

namespace EasyElementorAddons\Modules\Lottie;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-lottie';
    }

    public function get_widgets() {
        $widgets = [
            'Lottie',
        ];
        return $widgets;
    }

}
