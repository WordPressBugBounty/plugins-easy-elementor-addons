<?php

namespace EasyElementorAddons\Modules\DataTable;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-data-table';
    }

    public function get_widgets() {
        $widgets = [
            'DataTable',
        ];
        return $widgets;
    }

}
