<?php


namespace hw23;


use hw23\db\Db;
use hw23\db\ObjectWatcher;

/**
 * Class App
 * @package hw23
 */
class App
{
    private static $_instance = null;

    public function __construct(){}
    public function __clone(){}
    public function __wakeup(){}

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = [
                'db' => new Db(),
                'objectWatcher' => new ObjectWatcher()
            ];
        }
        return self::$_instance;
    }
}