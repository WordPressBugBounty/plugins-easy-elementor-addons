<?php

namespace EasyElementorAddons\Modules\WhatsappChat;

use EasyElementorAddons\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'eead-whatsapp-chat';
    }

    public function get_widgets() {
        $widgets = [
            'WhatsappChat',
        ];
        return $widgets;
    }

}
