<?php

namespace App\Http\Validators;


use App\Http\Validators\Contracts\ValidatorInterface;

class NotNullValidator extends BaseValidator
{
    public function validate()
    {
        return is_null($this->field) ? false : true;
    }
}
