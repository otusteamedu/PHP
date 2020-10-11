<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use Otus\Exceptions\UnknownDriver;
use Throwable;

class ConnectionFactory
{
    public static function make(ConfigContract $config): ConnectionContract
    {
        $connection = $config->get('default');
        $connectionClass = self::getConnectionClass($connection);

        try {
            return new $connectionClass($config);
        } catch (Throwable $throwable) {
            throw new UnknownDriver($connection);
        }
    }

    private static function getConnectionClass(string $driver): string
    {
        return "Otus\\Database\\".ucfirst($driver).'Connection';
    }
}
