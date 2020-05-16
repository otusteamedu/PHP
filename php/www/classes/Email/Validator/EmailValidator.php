<?php

namespace Classes\Email\Validator;

interface EmailValidator
{
    public function isValid(string $email): bool;
    public function getErrorMessage(): string;
}
