<?php

namespace App;

/**
 * Interface EmailValidatorInterface
 * @package App
 */
interface EmailValidatorInterface
{
    /**
     * @param string $email
     * @param array  $log
     * @return bool
     */
    public function run(string $email, array &$log = []): bool;
}
