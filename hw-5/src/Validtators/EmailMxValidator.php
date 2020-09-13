<?php

namespace App\Http\Validators;


use AAntonov\Validators\BaseValidator;

class EmailMxValidator extends BaseValidator
{
    private const DNS_TYPE = 'MX';

    public function validate()
    {
        return checkdnsrr(explode('@', $this->field)[1], self::DNS_TYPE);
    }
}
