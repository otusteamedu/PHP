<?php

namespace App\Validation\Condition;

class EmailCondition implements ConditionInterface
{
    public function validate($data)
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL) === false) {
            throw new \RuntimeException('Некорректный формат email');
        }
    }
}