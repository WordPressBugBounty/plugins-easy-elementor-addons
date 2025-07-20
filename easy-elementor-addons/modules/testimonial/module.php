<?php

namespace EasyElementorAddons\Modules\Testimonial;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-testimonial';
    }

    public function get_widgets() {
        $widgets = [
            'Testimonial',
        ];
        return $widgets;
    }

}
