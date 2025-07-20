<?php

namespace EasyElementorAddons\Modules\StickyVideo;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-sticky-video';
    }

    public function get_widgets() {
        $widgets = [
            'StickyVideo',
        ];
        return $widgets;
    }

}
