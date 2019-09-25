<?php

namespace EmailVerifier\Validator;

interface ValidatorInterface
{
    public function validate(string $email): bool;
}