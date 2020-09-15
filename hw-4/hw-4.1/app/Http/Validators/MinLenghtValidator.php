<?php

namespace App\Http\Validators;


use App\Http\Validators\Contracts\ValidatorInterface;

class MinLenghtValidator extends BaseValidator
{

    private $length;

    public function __construct($field, int $length)
    {
        parent::__construct($field);
        $this->length = $length;
    }

    public function validate()
    {
        return strlen($this->field) >= $this->length ? true : false;
    }
}
