<?php

namespace App;

/**
 * Class Responser
 *
 * @package App
 */
class Responser
{
    public static function response(): void
    {
        http_response_code(200);
        echo 'String is valid';
    }
}