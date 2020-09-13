<?php

namespace AAntonov\Validators;


class NotNullValidator extends BaseValidator
{
    public function validate()
    {
        if (($is_valid = !is_null($this->field)) === false) {
            $this->serError('Email is required');
        }
        return $is_valid;
    }
}
