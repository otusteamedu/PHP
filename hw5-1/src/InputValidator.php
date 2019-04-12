<?php

namespace timga\calculator;

class InputValidator
{
    private static $allowedActions = ["add","subtract"];

    public static function validateValue(float $value): bool
    {
        if (is_numeric($value)) {
            return true;
        }
        return false;
    }

    public static function validateAction(string $action): bool
    {
        if (in_array($action, self::$allowedActions)) {
            return true;
        }
        return false;
    }
}