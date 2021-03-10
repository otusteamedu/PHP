<?php

declare(strict_types=1);

namespace App\Apps;

class AppTypes
{

    public const SERVER = 'server';
    public const CLIENT = 'client';

    public static function get(): array
    {
        return [
            self::SERVER,
            self::CLIENT,
        ];
    }

    public static function isExist(string $appType): bool
    {
        return in_array($appType, self::get());
    }

}
