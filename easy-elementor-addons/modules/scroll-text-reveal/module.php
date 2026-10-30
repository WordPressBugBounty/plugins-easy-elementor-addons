<?php

namespace EasyElementorAddons\Modules\ScrollTextReveal;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-scroll-text-reveal';
    }

    public function get_widgets() {
        $widgets = [
            'ScrollTextReveal',
        ];
        return $widgets;
    }

}
