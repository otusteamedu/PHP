<?php

namespace nvggit;

/**
 * Class EmailValidator
 */
class EmailValidator
{
    private $validateCode;

    const VALIDATE_FILTER_FALSE = 1;
    const VALIDATE_MX_FALSE = 2;

    /**
     * Run full validation
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        if (!$this->validateFilter($email)) {
            $this->validateCode = self::VALIDATE_FILTER_FALSE;
            return false;
        }
        if (!$this->validateMX($this->getEmailDomain($email))) {
            $this->validateCode = self::VALIDATE_MX_FALSE;
            return false;
        }
        return true;
    }

    /**
     * Validate by MX check
     * @param string $domain
     * @return bool
     */
    protected function validateMX(string $domain): bool
    {
        return (bool) checkdnsrr($domain, 'MX');
    }

    /**
     * Validate email string
     * @param string $email
     * @return bool
     */
    protected function validateFilter(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Get domain from email string
     * @param string $email
     * @return string
     */
    public function getEmailDomain(string $email): string
    {
        return substr($email, strrpos($email, '@'));
    }

    /**
     * Get validate message
     * @return string
     */
    public function getMessage(): string
    {
        if ($this->validateCode === self::VALIDATE_FILTER_FALSE) {
            return "Email is not valid!";
        }
        if ($this->validateCode === self::VALIDATE_MX_FALSE) {
            return "Email domain does not exist!";
        }
        return "Email is valid!";
    }
}