<?php

namespace TimGa\hw26\validator;

class ResultCheckInputValidator extends AbstractValidator implements ValidatorInterface
{

    public function isValid($value): bool
    {
        if (is_int($value)) {
            return true;
        }
        $this->setError('Request ID must be an integer');
        return false;
    }

}
