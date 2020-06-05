<?php

namespace Marchenko;

class RuleFactory
{
    private static $dir = "rules";

    public static function getDir()
    {
        return self::$dir;
    }

    public static function getRule(string $file)
    {
        $class = 'Marchenko\\rules\\' . pathinfo($file)['filename'];

        $file =  __DIR__ . DIRECTORY_SEPARATOR . self::$dir . DIRECTORY_SEPARATOR . pathinfo($file)['basename'];
        if (!file_exists($file)) {
            throw new \Exception("File: '$file' does not exist");
        }

        require_once($file);
        if (!class_exists($class)) {
            throw new \Exception("Class: '$class' does not exist");
        }

        $rule = new $class();
        return $rule;
    }
}
