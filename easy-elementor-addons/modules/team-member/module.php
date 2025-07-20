<?php

namespace EasyElementorAddons\Modules\TeamMember;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-team-member';
    }

    public function get_widgets() {
        $widgets = [
            'TeamMember',
        ];
        return $widgets;
    }

}
