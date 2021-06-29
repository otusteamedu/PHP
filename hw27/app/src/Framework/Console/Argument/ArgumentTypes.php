<?php

declare(strict_types=1);

namespace App\Framework\Console\Argument;

class ArgumentTypes
{
    public const STRING  = 0;
    public const INTEGER = 1;
    public const DATE    = 2;
    public const ARRAY   = 3;

    public static function get(): array
    {
        return [
            self::STRING,
            self::INTEGER,
            self::DATE,
            self::ARRAY,
        ];
    }
}