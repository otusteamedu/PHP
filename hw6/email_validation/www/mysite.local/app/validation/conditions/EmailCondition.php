<?php

namespace App\Validation\Condition;

use App\Exceptions\ValidationErrorException;

class EmailCondition implements ConditionInterface
{
    public function validate($data)
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationErrorException('Некорректный формат email');
        }
    }
}