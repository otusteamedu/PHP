<?php


namespace App\Utils\Validation;


interface ValidatorInterface
{
    public function validate($value): bool;

    public function getErrors(): array;
}
