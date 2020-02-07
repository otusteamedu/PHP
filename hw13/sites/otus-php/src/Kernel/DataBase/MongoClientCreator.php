<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

use MongoDB;
use Exception;

class MongoClientCreator implements ClientCreatorInterface
{
    /**
     * @param array $config
     * @return object
     * @throws Exception
     */
    public static function create(array $config): object
    {
        if (empty($config['mongo_db_user'])
            || empty($config['mongo_db_password'])
            || empty($config['mongo_db'])
            || empty($config['mongo_db_port'])
        ) {
            throw new Exception('Установите параметры доступа к хранилищу данных');
        }

        $user = $config['mongo_db_user'];
        $pwd = $config['mongo_db_password'];
        $dbName = $config['mongo_db'];
        $dbPort = $config['mongo_db_port'];
        $mongoClient = new MongoDB\Client("mongodb://{$user}:{$pwd}@mongodb:{$dbPort}");

        return $mongoClient->$dbName;
    }
}