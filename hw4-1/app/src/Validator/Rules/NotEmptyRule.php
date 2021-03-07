<?php

declare(strict_types=1);

namespace App\Validator\Rules;

class NotEmptyRule implements RuleInterface
{

    public function validate($value): bool
    {
        return !empty($value);
    }

    public function getErrorMessage(): string
    {
        return 'Значение обязательно для заполнения';
    }

}