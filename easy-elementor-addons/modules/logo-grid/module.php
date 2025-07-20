<?php

namespace EasyElementorAddons\Modules\LogoGrid;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-logo-grid';
    }

    public function get_widgets() {
        $widgets = [
            'LogoGrid',
        ];
        return $widgets;
    }

}
