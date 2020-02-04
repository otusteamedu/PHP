<?php

namespace App\EmailValidators;

use App\EmailValidatorInterface;

use function checkdnsrr;

/**
 * Class EmailDNSmxValidator
 * @package App\EmailValidators
 */
class EmailDNSmxValidator implements EmailValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function run(string $email, array &$log = []): bool
    {
        preg_match('#@(.+)$#', $email, $matches);
        $hostname = $matches[1] ?? null;

        if (!$hostname) {
            return false;
        }

        $result = checkdnsrr($hostname, 'MX');

        $log[$email] = $result ? 'OK' : 'Не найдена MX запись';

        return $result;
    }
}
