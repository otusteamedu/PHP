<?php

namespace Validator;

class StructureValidator extends AbstractValidator
{
    CONST VIOLATION = 'Email structure incorrect';

    public function validate(string $email)
    {
        return (bool)preg_match("/.+@.+/", $email) == 1;
    }
}
