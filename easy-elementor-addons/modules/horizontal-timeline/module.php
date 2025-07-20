<?php

namespace EasyElementorAddons\Modules\HorizontalTimeline;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-horizontal-timeline';
    }

    public function get_widgets() {
        $widgets = [
            'HorizontalTimeline',
        ];
        return $widgets;
    }

}
