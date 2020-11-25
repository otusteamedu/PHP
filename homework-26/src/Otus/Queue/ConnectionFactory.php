<?php

namespace Otus\Queue;

use Otus\Config\ConfigContract;
use Otus\Exceptions\UnknownDriver;
use Throwable;

class ConnectionFactory
{
    public static function make(ConfigContract $config): ConnectionContract
    {
        $connection = $config->get('default_queue');
        $connectionClass = self::getConnectionClass($connection);

        try {
            return new $connectionClass($config);
        } catch (Throwable $throwable) {
            throw new UnknownDriver($connection);
        }
    }

    private static function getConnectionClass(string $driver): string
    {
        return "Otus\\Queue\\".ucfirst($driver).'Connection';
    }
}