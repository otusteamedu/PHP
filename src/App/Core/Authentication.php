<?php

namespace Ozycast\App\Core;

use Ozycast\App\Models\Client;

class Authentication
{
    /**
     * Вернет найденного пользователя
     * @return DTO|null
     */
    public static function check()
    {
        $api_key_name = $_ENV["AUTHENTICATION_KEY_NAME"];

        $header = getallheaders();
        $api_key = $header[$api_key_name];

        $user = Client::findByKey($api_key);
        return $user;
    }
}