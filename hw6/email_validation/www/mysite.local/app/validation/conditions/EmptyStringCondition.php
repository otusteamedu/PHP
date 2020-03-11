<?php

namespace App\Validation\Condition;

class EmptyStringCondition implements ConditionInterface
{
    public function validate($data)
    {
        if ($data === '') {
            throw new \RuntimeException('Строка не должна быть пустой');
        }
    }
}