<?php

namespace App\Util;

class EmailHelper
{
    public static function getHostFromEmail(string $email): string
    {
        return (string)explode('@', $email)[1];
    }
}