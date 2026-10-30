<?php

namespace EasyElementorAddons\Modules\SocialIcons;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-social-icons';
    }

    public function get_widgets() {
        $widgets = [
            'SocialIcons',
        ];
        return $widgets;
    }

}
