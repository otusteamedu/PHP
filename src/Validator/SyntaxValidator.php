<?php

namespace EmailVerifier\Validator;

use EmailVerifier\Exceptions\EmailSyntaxIsNotValid;

/**
 * Class BasicValidator
 * @package EmailVerifier\Validator
 */
class SyntaxValidator implements ValidatorInterface
{

    public function validate(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailSyntaxIsNotValid();
        }
    }
}