<?php

declare(strict_types=1);

namespace App\Validator\Rules;

class NumberOfParenthesesRule implements RuleInterface
{

    public function validate($value): bool
    {
        $numberOfOpened = substr_count($value, '(');
        $numberOfClosed = substr_count($value, ')');

        return ($numberOfOpened === $numberOfClosed);
    }

    public function getErrorMessage(): string
    {
        return 'Количество открытых и закрытых скобок не совпадает';
    }

}