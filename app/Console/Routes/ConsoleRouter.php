<?php

namespace App\Console\Routes;


use Routes\PreparedArgs;
use Routes\Router;


class ConsoleRouter
{
    static public function run(array $arguments): void
    {
        self::setUrlFromCliRequest($arguments);
        Router::run();
    }

    static private function setUrlFromCliRequest(array $arguments): void
    {
        $argument = mb_strtolower(($arguments[1] ?? '') . '/' . ($arguments[2] ?? ''));
        echo $argument.PHP_EOL;
        PreparedArgs::setUriRequest(self::getRouteByArgument($argument));
    }

    static private function getRouteByArgument(string $argument): string
    {
        return match ($argument) {
            'command/' => '/Controller/Method',
            default => '',
        };
    }
}