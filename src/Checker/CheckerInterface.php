<?php

namespace EmailVerifier\Checker;

interface CheckerInterface
{
    public function exists(string $email): bool;
}