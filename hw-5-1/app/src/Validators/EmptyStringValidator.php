<?php

namespace Validators;

class EmptyStringValidator extends Validator
{
    public function check (string $string): bool
    {
        if ($string === '') {
            echo 'string is empty' . PHP_EOL;
            return false;
        }

        return parent::check($string);
    }
}