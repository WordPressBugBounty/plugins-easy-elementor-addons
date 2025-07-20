<?php

namespace EasyElementorAddons\Modules\OnePageNavigation;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-one-page-nav';
    }

    public function get_widgets() {
        $widgets = [
            'OnePageNavigation',
        ];
        return $widgets;
    }

}
