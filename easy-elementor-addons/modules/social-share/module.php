<?php

namespace EasyElementorAddons\Modules\SocialShare;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-social-share';
    }

    public function get_widgets() {
        $widgets = [
            'SocialShare',
        ];
        return $widgets;
    }

}
