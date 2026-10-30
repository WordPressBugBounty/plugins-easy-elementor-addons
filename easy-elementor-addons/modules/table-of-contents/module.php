<?php

namespace EasyElementorAddons\Modules\TableOfContents;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-table-of-contents';
    }

    public function get_widgets() {
        $widgets = [
            'TableOfContents',
        ];
        return $widgets;
    }

}
