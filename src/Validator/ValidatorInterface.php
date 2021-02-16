<?php


namespace App\Validator;


interface ValidatorInterface
{
    public function validate($value): bool;

    public function getErrors(): array;
}
