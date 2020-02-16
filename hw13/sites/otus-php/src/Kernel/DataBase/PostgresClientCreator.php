<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

use Exception;
use PDO;

class PostgresClientCreator implements ClientCreatorInterface
{
    /**
     * @param array $config
     * @return object
     * @throws Exception
     */
    public static function create(array $config): object
    {
        if (empty($config['postgres_user'])
            || empty($config['postgres_password'])
            || empty($config['postgres_db'])
            || empty($config['postgres_host'])
            || empty($config['postgres_port'])
        ) {
            throw new Exception('Установите параметры доступа к хранилищу данных');
        }

        $user = $config['postgres_user'];
        $pwd = $config['postgres_password'];
        $dbName = $config['postgres_db'];
        $dbHost = $config['postgres_host'];
        $dbPort = $config['postgres_port'];
        $dbh = new PDO(
            "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}",
            $user,
            $pwd ,
            [PDO::ATTR_PERSISTENT => true]
        );

        return $dbh;
    }
}