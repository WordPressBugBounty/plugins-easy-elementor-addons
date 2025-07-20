<?php

namespace EasyElementorAddons\Modules\PieChart;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-pie-chart';
    }

    public function get_widgets() {
        $widgets = [
            'PieChart',
        ];
        return $widgets;
    }

}
