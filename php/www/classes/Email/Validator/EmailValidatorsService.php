<?php

namespace Classes\Email\Validator;

interface EmailValidatorsService
{
    public function isValid(string $email): bool;
    public function getErrors(): array;
}
