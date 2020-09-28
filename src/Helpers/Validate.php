<?php

namespace Helpers;

class Validate
{
    public static function validateEvent(array $arr): bool
    {
        return array_key_exists('priority', $arr) && array_key_exists('conditions', $arr) && is_int($arr['priority']) && is_array($arr['conditions']);
    }

    public static function validateSearchEvent(array $arr): bool
    {
        return array_key_exists('params', $arr) && is_array($arr['params']);
    }
}