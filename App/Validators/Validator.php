<?php

namespace App\Validators;


interface Validator
{

    public function isValid(): bool;

    public function validate(): Validator;

    public function setValue($value): Validator;

}