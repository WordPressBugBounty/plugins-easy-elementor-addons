<?php

namespace EasyElementorAddons\Modules\PricingTable;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-pricing-table';
    }

    public function get_widgets() {
        $widgets = [
            'PricingTable',
        ];
        return $widgets;
    }

}
