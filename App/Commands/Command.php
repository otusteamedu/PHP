<?php

namespace App\Commands;
abstract class Command
{
    abstract function getName(): string;

    abstract protected function init($arguments = []): void;

    public static function run(string $command, $arguments = []): void
    {
        foreach (glob(__DIR__ . '/*.php') as $file) {
            $class = __NAMESPACE__ . '\\' . basename($file, '.php');
            if ($class !== self::class && class_exists($class)) {
                $commandObject = (new $class);
                if ($commandObject->getName() === $command) {
                    $commandObject->init($arguments);
                }
            }
        }
    }
}