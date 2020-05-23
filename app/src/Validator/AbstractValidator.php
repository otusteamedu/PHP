<?php

namespace Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    CONST VIOLATION = '';

    abstract public function validate(string $emails);

    public function getViolation()
    {
        return static::VIOLATION;
    }
}
