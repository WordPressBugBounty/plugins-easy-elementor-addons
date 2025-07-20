<?php

namespace EasyElementorAddons\Modules\HorizontalTab;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-horizontal-tab';
    }

    public function get_widgets() {
        $widgets = [
            'HorizontalTab',
        ];
        return $widgets;
    }

}
