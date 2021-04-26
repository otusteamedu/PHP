<?php

namespace Src\Models;

/**
 * Class Condition
 *
 * @package Src\Models
 */
class Condition
{
    public const CONDITIONS_SEPARATOR = '=';

    public static function getConditionString (string $key, string $value): string
    {
        return $key . self::CONDITIONS_SEPARATOR . $value;
    }
}