<?php

namespace AAntonov\Validators;


class EmailMxValidator extends BaseValidator
{
    private const DNS_TYPE = 'MX';

    public function validate()
    {
        $host = explode('@', $this->field)[1];
        if (($is_valid = checkdnsrr($host, self::DNS_TYPE)) === false) {
            $this->setError('Mx record is not exists for domain ' . $host);
        }
        return $is_valid;
    }
}
