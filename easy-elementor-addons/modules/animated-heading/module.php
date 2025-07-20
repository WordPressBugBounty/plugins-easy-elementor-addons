<?php

namespace EasyElementorAddons\Modules\AnimatedHeading;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-animated-heading';
    }

    public function get_widgets() {
        $widgets = [
            'AnimatedHeading',
        ];
        return $widgets;
    }

}
