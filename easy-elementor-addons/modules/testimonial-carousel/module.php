<?php

namespace EasyElementorAddons\Modules\TestimonialCarousel;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Module extends Module_Base {

    public function get_name() {
        return 'eead-testimonial-carousel';
    }

    public function get_widgets() {
        $widgets = [
            'TestimonialCarousel',
        ];
        return $widgets;
    }

}
