<?php

namespace Validators;

class BracketsValidator {

    private string $_string;

    public function __construct (string $string)
    {
        $this->_string = $string;
    }

    public function validate(): bool
    {
        return false;
    }
}