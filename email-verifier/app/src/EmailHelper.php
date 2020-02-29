<?php

namespace App;

use function explode;


class EmailHelper
{
    public static function getHostByEmail(string $email): ?string
    {
        return explode('@', $email)[1] ?? null;
    }
}