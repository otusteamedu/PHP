<?php

declare(strict_types=1);

namespace App\Validator;

class NotEmptyValidator
{

    public function validate(string $value): bool
    {
        return !empty($value);
    }

}