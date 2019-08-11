<?php


namespace nvggit\hw26;

/**
 * Class App
 * @package nvggit\hw26
 *
 */
class App
{
    private static $_instance = null;

    public function __construct(){}

    public function __clone(){}

    public function __wakeup(){}

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = [
            ];
        }
        return self::$_instance;
    }
}