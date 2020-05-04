<?php

namespace Validator;

class ParenthesisCountValidator extends AbstractValidator
{
    const VIOLATION = 'The number of opening and closing parentheses is not equal;';

    /** @inheritDoc */
    public function validate()
    {
        if (array_key_exists('string', $this->request)
            && strlen($this->request['string']) > 0) {
            $str = $this->request['string'];
            $data = count_chars($str, 1);
            if ($data[40] <> $data[41]) {
                return false;
            }
        }

        return true;
    }
}
