<?php

namespace App\Validation\Condition;

interface ConditionInterface
{
    public function validate($data);
}