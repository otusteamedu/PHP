<?php

namespace Validators;

class EmailMXValidator extends Validator
{
    public function check (string $string): bool
    {
        $exploded = explode('@', $string);
        $hostname = $exploded[1] ?? '';

        if ($hostname === '' || !checkdnsrr($hostname, "MX")) {
            echo 'email did not pass MX validation' . PHP_EOL;
            return false;
        }

        return parent::check($string);
    }
}