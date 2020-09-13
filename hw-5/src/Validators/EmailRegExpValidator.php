<?php

namespace AAntonov\Validators;


class EmailRegExpValidator extends BaseValidator
{
    public function __construct($field)
    {
        parent::__construct($field);
    }

    public function validate()
    {
        if (($is_valid = filter_var($this->field, FILTER_VALIDATE_EMAIL) ? true : false) === false) {
            $this->serError('Email is invalid');
        }
        return $is_valid;
    }
}
