<?php

namespace AAntonov\Validators;


class NotNullValidator extends BaseValidator
{
    public function validate()
    {
        if (($is_valid = (bool) $this->field) === false) {
            $this->setError('Email is required');
        }
        return $is_valid;
    }
}
