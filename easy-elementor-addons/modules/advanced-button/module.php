<?php

namespace EasyElementorAddons\Modules\AdvancedButton;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-advanced-button';
    }

    public function get_widgets() {
        $widgets = [
            'AdvancedButton',
        ];
        return $widgets;
    }

}
