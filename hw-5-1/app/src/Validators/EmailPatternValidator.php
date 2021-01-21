<?php

namespace Validators;

class EmailPatternValidator extends Validator
{
    private const EMAIL_CHECK_PATTERN = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';

    public function check (string $string): bool
    {
        if (!preg_match(self::EMAIL_CHECK_PATTERN, $string)) {
            echo 'email did not pass template validation' . PHP_EOL;
            return false;
        }

        return parent::check($string);
    }
}