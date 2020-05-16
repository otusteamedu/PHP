<?php

namespace Classes\Email\Validator;

interface Validators
{
    public const EMAIL_VALIDATORS_LIST = [
        RegExpEmailValidator::class,
        MxEmailValidator::class
    ];
}
