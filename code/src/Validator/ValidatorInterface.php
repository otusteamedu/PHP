<?php

namespace EmailChecker\Validator;

interface ValidatorInterface
{
    public function validate(string $email);
}