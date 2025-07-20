<?php

namespace EasyElementorAddons\Modules\LogoCarousel;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-logo-carousel';
    }

    public function get_widgets() {
        $widgets = [
            'LogoCarousel',
        ];
        return $widgets;
    }

}
