<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use UnknownDriver;

class ConnectionFactory
{
    public static function make(ConfigContract $config)
    {
        switch ($config->get('db_driver')) {
            case 'mysql':
                return new MysqlConnection($config);
            case 'postgres':
                return new PostgresConnection($config);
            case 'sqlite':
                return new SqliteConnection($config);
            default:
                throw new UnknownDriver();
        }
    }
}
