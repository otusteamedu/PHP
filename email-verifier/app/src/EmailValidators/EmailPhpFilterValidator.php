<?php

namespace App\EmailValidators;

use App\EmailValidatorInterface;

use function filter_var;

/**
 * Class EmailPhpFilterValidator
 * @package App\EmailValidators
 */
class EmailPhpFilterValidator implements EmailValidatorInterface
{
    /**
     * @param string $email
     * @param array  $log
     * @return bool
     */
    public function run(string $email, array &$log = []): bool
    {
        $result = (bool)filter_var($email, FILTER_VALIDATE_EMAIL);

        $log[$email] = $result ? 'OK' : 'Email не прошел фильтрацию';

        return $result;
    }
}
