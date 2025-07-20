<?php

namespace EasyElementorAddons\Modules\FeatureList;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-feature-list';
    }

    public function get_widgets() {
        $widgets = [
            'FeatureList',
        ];
        return $widgets;
    }

}
