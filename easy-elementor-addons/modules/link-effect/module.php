<?php

namespace EasyElementorAddons\Modules\LinkEffect;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-link-effect';
    }

    public function get_widgets() {
        $widgets = [
            'LinkEffect',
        ];
        return $widgets;
    }

}
