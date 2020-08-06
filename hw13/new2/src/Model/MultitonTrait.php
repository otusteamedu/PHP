<?php


namespace AYakovlev\Model;


trait MultitonTrait
{
    private static array $list = [];

    public static function getInstance(string $instance = 'default'): self
    {
        if (empty(self::$list[$instance])) {
            self::$list[$instance] = new static();
        }

        return self::$list[$instance];
    }

    // no create instance
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}