<?php

namespace EasyElementorAddons\Modules\VerticalTab;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-vertical-tab';
    }

    public function get_widgets() {
        $widgets = [
            'VerticalTab',
        ];
        return $widgets;
    }

}
