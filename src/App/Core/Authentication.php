<?php

namespace Ozycast\App\Core;

use Ozycast\App\Models\Client;

class Authentication
{
    const API_KEY = "Api-Key";

    /**
     * Вернет найденного пользователя
     * @return DTO|null
     */
    public static function check()
    {
        $header = getallheaders();
        $api_key = $header[self::API_KEY];

        $user = Client::findByKey($api_key);
        return $user;
    }
}