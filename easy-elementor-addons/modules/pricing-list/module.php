<?php

namespace EasyElementorAddons\Modules\PricingList;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-pricing-list';
    }

    public function get_widgets() {
        $widgets = [
            'PricingList',
        ];
        return $widgets;
    }

}
