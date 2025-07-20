<?php

namespace EasyElementorAddons\Modules\PopupVideo;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-popup-video';
    }

    public function get_widgets() {
        $widgets = [
            'PopupVideo',
        ];
        return $widgets;
    }

}
