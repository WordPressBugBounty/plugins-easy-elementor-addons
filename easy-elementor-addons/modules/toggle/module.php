<?php

namespace EasyElementorAddons\Modules\Toggle;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-toggle';
    }

    public function get_widgets() {
        $widgets = [
            'Toggle',
        ];
        return $widgets;
    }

}
