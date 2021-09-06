<?php

namespace App\Console\Routes;


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
        print_r($arguments);
        $argument = mb_strtolower(($arguments[1] ?? '') . '/' . ($arguments[2] ?? ''));
        echo $argument.PHP_EOL;
        $_SERVER['REQUEST_URI'] = self::getRouteByArgument($argument);
    }

    static private function getRouteByArgument(string $argument): string
    {
        return match ($argument) {
            'elasticsearch/' => '/Elasticsearch/xhrCheckConnection',
            'redis/' => '/Redis/xhrCheckConnection',
            'memcached/' => '/Memcached/AloneMemcached/xhrCheckConnection',
            'mysql/mysqli' => '/Mysql/xhrCheckMysqliConnection',
            'mysql/pdo' => '/Mysql/xhrCheckPdoConnection',
            'postgres/pdo' => '/Postgres/xhrCheckPdoConnection',
            'postgres/pg_connect' => '/Postgres/xhrCheckPgConnection',
            'sysinfo/' => '/Sysinfo/xhrGetInfo',
            default => '',
        };
    }
}