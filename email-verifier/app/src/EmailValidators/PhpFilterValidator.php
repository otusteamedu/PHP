<?php

namespace App\EmailValidators;

use App\AbstractEmailValidator;
use App\EmailValidatorException;
use function filter_var;
use const FILTER_VALIDATE_EMAIL;


class PhpFilterValidator extends AbstractEmailValidator
{
    public function validate(string $email): void
    {
        if (!(bool) filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidatorException('Email не прошел стандартный PHP фильтр');
        }

        parent::validate($email);
    }
}