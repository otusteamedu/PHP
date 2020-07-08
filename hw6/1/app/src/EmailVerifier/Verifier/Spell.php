<?php
declare(strict_types=1);

namespace EmailVerifier\Verifier;

use EmailVerifier\EmailVerifierException;

class Spell implements VerifierInterface
{
    /**
     * @throws EmailVerifierException
     */
    public function verify(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new EmailVerifierException(
                'Не правильное написание email-адреса ' . $email
            );
        }
    }
}