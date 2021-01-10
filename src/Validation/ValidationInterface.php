<?php

namespace EmailValidator\Validation;

interface ValidationInterface
{
    public function isValid(string $email): bool;
}