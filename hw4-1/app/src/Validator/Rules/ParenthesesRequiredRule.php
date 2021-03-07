<?php

declare(strict_types=1);

namespace App\Validator\Rules;

class ParenthesesRequiredRule implements RuleInterface
{

    public function validate($value): bool
    {
        return (preg_match('/\(|\)+/', $value) === 1);
    }

    public function getErrorMessage(): string
    {
        return 'Значение должно содержать символы круглых скобок';
    }

}