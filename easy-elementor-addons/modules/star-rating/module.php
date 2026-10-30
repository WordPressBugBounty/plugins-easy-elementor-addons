<?php

namespace EasyElementorAddons\Modules\StarRating;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-star-rating';
    }

    public function get_widgets() {
        $widgets = [
            'StarRating',
        ];
        return $widgets;
    }

}
