<?php

namespace EmailVerifier\Validator;

/**
 * Class BasicValidator
 * @package EmailVerifier\Validator
 */
class BasicValidator implements ValidatorInterface
{

    public function validate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}