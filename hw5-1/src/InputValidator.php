<?php

namespace timga\calculator;

class InputValidator
{
    private static $allowedActions = ["add","subtract"];

    public static function validateValue(float $value): bool
    {
        return is_numeric($value);
    }

    public static function validateAction(string $action): bool
    {
        return in_array($action, self::$allowedActions);
    }
}