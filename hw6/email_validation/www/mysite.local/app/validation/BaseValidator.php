<?php

namespace App\Validation;

use App\Validation\Condition\ConditionInterface;

class BaseValidator implements ValidatorInterface
{
    /** @var ConditionInterface[] $conditions */
    protected $conditions = [];

    public function validate($data)
    {
        foreach ($this->conditions as $condition) {
            $condition->validate($data);
        }
    }

    public function addCondition(ConditionInterface $condition)
    {
        $this->conditions[] = $condition;
        return $this;
    }
}