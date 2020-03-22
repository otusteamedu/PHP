<?php

declare(strict_types=1);

namespace App\DataBase;

use Predis;
use Exception;

class RedisClientCreator implements ClientCreatorInterface
{
    /**
     * @param array $config
     * @return object
     * @throws Exception
     */
    public static function create(array $config): Predis
    {
        if (empty($config['redis_port'])) {
            throw new \Exception('Установите параметры доступа к хранилищу данных');
        }

        $dbPort = $config['redis_port'];

        return new Predis\Client("tcp://redis:{$dbPort}");
    }
}