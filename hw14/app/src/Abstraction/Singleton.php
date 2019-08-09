<?php
/**
* Abstract class for Singleton pattern entites
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Abstraction;

abstract class Singleton
{
    /**
    * @var array - contains all singleton instances
    */
    private static $instances = [];

    /**
    * Returns instance object
    *
    * @return Jekys\Singleton
    */
    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
    * Blocks direct object creation
    */
    protected function __construct()
    {
    }

    /**
    * Blocks object cloning
    */
    private function __clone()
    {
    }

    /**
    * Blocks direct wakeup call
    */
    private function __wakeup()
    {
    }
}
