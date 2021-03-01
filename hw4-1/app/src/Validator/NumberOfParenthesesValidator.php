<?php

declare(strict_types=1);

namespace App\Validator;

class NumberOfParenthesesValidator
{

    public function validate(string $value): bool
    {
        $numberOfOpened = substr_count($value, '(');
        $numberOfClosed = substr_count($value, ')');

        return ($numberOfOpened === $numberOfClosed);
    }

}