<?php

namespace AAntonov\Validators;


use AAntonov\Validators\Contracts\ValidatorInterface;

abstract class BaseValidator implements ValidatorInterface
{
    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public abstract function validate();
}
