<?php

namespace App\Models;

class Condition
{
    public const CONDTITIONS_STRING_SEPARATOR = '=';

    public static function getConditionString (string $k, string $v): string
    {
        return $k . self::CONDTITIONS_STRING_SEPARATOR . $v;
    }
}