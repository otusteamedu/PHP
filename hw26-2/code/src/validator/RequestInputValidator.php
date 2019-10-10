<?php

namespace TimGa\hw26\validator;

class RequestInputValidator extends AbstractValidator implements ValidatorInterface
{

    public function isValid($value): bool
    {
        if (is_int($value)) {
            return true;
        }
        $this->setError('Input value must be an integer');
        return false;
    }

}
