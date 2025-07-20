<?php

namespace EasyElementorAddons\Modules\AdvancedHeading;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-advanced-heading';
    }

    public function get_widgets() {
        $widgets = [
            'AdvancedHeading',
        ];
        return $widgets;
    }

}
