<?php

namespace EasyElementorAddons\Modules\PopupModal;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-popup-modal';
    }

    public function get_widgets() {
        $widgets = [
            'PopupModal',
        ];
        return $widgets;
    }

}
