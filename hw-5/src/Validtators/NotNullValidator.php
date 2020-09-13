<?php

namespace App\Http\Validators;


use AAntonov\Validators\BaseValidator;

class NotNullValidator extends BaseValidator
{
    public function validate()
    {
        return is_null($this->field) ? false : true;
    }
}
