<?php


namespace Validator;


class EmptyValidator extends AbstractValidator
{
    const VIOLATION = 'Request is empty;';

    public function validate()
    {
        if (array_key_exists('string', $this->request)
            && strlen($this->request['string']) > 0) {
            return true;
        }
        return false;
    }

}
