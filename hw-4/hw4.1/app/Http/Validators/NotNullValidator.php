<?php

namespace App\Http\Validators;


class NotNullValidator extends BaseValidator
{
    public function validate()
    {
        return is_null($this->field) ? false : true;
    }
}
