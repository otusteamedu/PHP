<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\ClientMapper;

Class Client
{
    /**
     * Вернет данные клиента
     * @param $id
     * @return \Ozycast\App\Core\DTO|null
     */
    public static function getClient($id)
    {
        $client = (new ClientMapper(App::$db))->findOne(['id' => $id]);
        return $client;
    }

    /**
     * @param $key
     * @return \Ozycast\App\Core\DTO|null
     */
    public static function findByKey($key)
    {
        $client = (new ClientMapper(App::$db))->findOne(['api_key' => $key]);
        return $client;
    }
}