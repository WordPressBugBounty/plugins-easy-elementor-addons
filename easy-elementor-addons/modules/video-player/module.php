<?php

namespace EasyElementorAddons\Modules\VideoPlayer;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-video-player';
    }

    public function get_widgets() {
        $widgets = [
            'VideoPlayer',
        ];
        return $widgets;
    }

}
