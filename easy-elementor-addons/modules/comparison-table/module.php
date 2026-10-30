<?php

namespace EasyElementorAddons\Modules\ComparisonTable;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-comparison-table';
    }

    public function get_widgets() {
        $widgets = [
            'ComparisonTable',
        ];
        return $widgets;
    }

}
