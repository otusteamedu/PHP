<?php

declare(strict_types=1);

namespace App\Validator;

class ParenthesesRequiredValidator
{

    public function validate(string $value): bool
    {
        return (preg_match('/\(|\)+/', $value) === 1);
    }

}