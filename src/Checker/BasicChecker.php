<?php

namespace EmailVerifier\Checker;

/**
 * Class BasicChecker
 * @package EmailVerifier
 */
class BasicChecker implements CheckerInterface
{

    public function exists(string $email): bool
    {
        $emailParts = explode('@', $email);

        return checkdnsrr(array_pop($emailParts), 'MX');
    }
}