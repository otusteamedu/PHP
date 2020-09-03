<?php

namespace App\Http\Validators;


use App\Http\Validators\Contracts\ValidatorInterface;

abstract class BaseValidator
{
    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public abstract function validate();
}
