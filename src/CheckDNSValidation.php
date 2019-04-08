<?php

namespace HW7_1;

use InvalidArgumentException;
use function count;
use function get_class;
use function sprintf;

/**
 * Uses for validation MX records fod email's domain name
 *
 * Class CheckDNSValidation
 * @package HW7_1
 */
class CheckDNSValidation extends AbstractBaseValidation
{
    public function validate(string $email): bool
    {
        $email = trim($email);
        $this->debug(sprintf('Check email with %s, %s', get_class($this), $email));
        $result = $this->validateMX($this->retrieveHost($email));
        $this->debug(sprintf('Check result for email %s: %b', $email, $result));
        return $result;
    }

    /**
     * @param string $host
     * @return bool
     */
    private function validateMX(string $host): bool
    {
        $result = false;
        $mxHosts = [];
        if (getmxrr($host, $mxHosts)) {
            $result = count($mxHosts) > 0;
        }
        return $result;
    }

    /**
     * @param string $email
     * @return string
     */
    private function retrieveHost(string $email): string
    {
        $host = $email;

        if (false !== $pos = mb_strrpos($email, '@')) {
            $host = substr($email, $pos + 1);
        }
        if (!$host) {
            throw new InvalidArgumentException(sprintf('Can\'t retrieve hostname from %s', $email));
        }
        $variant = INTL_IDNA_VARIANT_2003;
        if (defined('INTL_IDNA_VARIANT_UTS46')) {
            $variant = INTL_IDNA_VARIANT_UTS46;
        }
        $host = rtrim(idn_to_ascii($host, IDNA_DEFAULT, $variant), '.') . '.';
        return $host;
    }
}
