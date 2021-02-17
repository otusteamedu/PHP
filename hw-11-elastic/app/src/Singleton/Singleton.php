<?php

namespace Singleton;

class Singleton
{
    private static array $instances = [];

    protected function __construct () { }

    protected function __clone () { }

    public function __wakeup () { }

    public static function getInstance ()
    {
        $subclass = static::class;

        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
    }
}