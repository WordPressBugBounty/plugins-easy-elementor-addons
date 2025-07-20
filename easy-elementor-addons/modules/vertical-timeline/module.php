<?php

namespace EasyElementorAddons\Modules\VerticalTimeline;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-vertical-timeline';
    }

    public function get_widgets() {
        $widgets = [
            'VerticalTimeline',
        ];
        return $widgets;
    }

}
