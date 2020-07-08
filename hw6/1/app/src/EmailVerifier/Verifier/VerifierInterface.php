<?php
declare(strict_types=1);

namespace EmailVerifier\Verifier;

use EmailVerifier\EmailVerifierException;

interface VerifierInterface
{
    /**
     * @throws EmailVerifierException
     */
    public function verify(string $str): void;
}