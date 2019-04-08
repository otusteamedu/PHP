<?php

namespace HW7_1;

/**
 *
 * Uses for simple regexp validation
 * @see filter_var()
 *
 * Class RegexpValidation
 * @package HW7_1
 */
class RegexpValidation extends AbstractBaseValidation
{
    public function validate(string $email): bool
    {
        $email = trim($email);
        $this->debug(sprintf('Check email with %s, %s', get_class($this), $email));
        $result = (bool)filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
        $this->debug(sprintf('Check result for email %s: %b', $email, $result));
        return $result;
    }
}
