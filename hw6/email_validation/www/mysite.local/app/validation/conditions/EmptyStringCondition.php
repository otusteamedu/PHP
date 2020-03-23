<?php

namespace App\Validation\Condition;

use App\Exceptions\ValidationErrorException;

class EmptyStringCondition implements ConditionInterface
{
    public function validate($data)
    {
        if ($data === '') {
            throw new ValidationErrorException('Строка не должна быть пустой');
        }
    }
}