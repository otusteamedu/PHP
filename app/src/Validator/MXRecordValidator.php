<?php

namespace Validator;

class MXRecordValidator extends AbstractValidator
{
    CONST VIOLATION = 'MX record does not exist';

    public function validate(string $email)
    {
        $parts = preg_split("/@/", $email);
        if (isset($parts[1])) {
            $mxrecords = [];
            getmxrr($parts[1], $mxrecords);
            return count($mxrecords) > 0;
        }
        return false;
    }
}
