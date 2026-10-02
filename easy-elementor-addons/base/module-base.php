<?php

namespace EasyElementorAddons\Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

abstract class Module_Base {

    /**
     * @var Module_Base[]
     */
    protected static $_instances = [];

    public static function class_name() {
        return get_called_class();
    }

    /**
     * @return static
     */
    public static function instance() {
        if (empty(static::$_instances[static::class_name()])) {
            static::$_instances[static::class_name()] = new static();
        }

        return static::$_instances[static::class_name()];
    }

    abstract public function get_name();

    public function get_widgets() {
        return [];
    }

    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'init_widgets']);
    }

    public function init_widgets($widgets_manager) {
        $namespace = substr(static::class, 0, strrpos(static::class, '\\'));

        foreach ($this->get_widgets() as $widget) {
            $class_name = $namespace . '\Widgets\\' . $widget;
            $widgets_manager->register(new $class_name());
        }
    }

}
