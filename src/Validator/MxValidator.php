<?php

namespace EmailVerifier\Validator;

use EmailVerifier\Exceptions\EmailIsNotExists;

/**
 * Class BasicChecker
 * @package EmailVerifier
 */
class MxValidator implements ValidatorInterface
{

    /**
     * @param string $email
     * @throws EmailIsNotExists
     */
    public function validate(string $email)
    {
        $emailParts = explode('@', $email);

        if(!checkdnsrr(array_pop($emailParts), 'MX')) {
            throw new EmailIsNotExists();
        }
    }
}