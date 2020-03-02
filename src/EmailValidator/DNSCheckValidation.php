<?php

namespace App\EmailValidator;

class DNSCheckValidation extends EmailValidation
{
    public function isValid(string $email): bool
    {
        $pos = strpos($email, '@');
        if (false === $pos) {
            $this->setError('No domain part for this email');
            return false;
        }

        if (0 === $pos) {
            $this->setError('No local part for this email');
            return false;
        }

        $host = substr($email, $pos + 1);
        if ('' === $host) {
            $this->setError('No domain part for this email');
            return false;
        }

        return $this->checkDNS($host);
    }

    protected function checkDNS(string $host): bool
    {
        $variant = defined('INTL_IDNA_VARIANT_UTS46') ? INTL_IDNA_VARIANT_UTS46 : INTL_IDNA_VARIANT_2003;
        $host = rtrim(idn_to_ascii($host, IDNA_DEFAULT, $variant), '.') . '.';
        $result = dns_get_record($host, DNS_MX);
        if (!$result) {
            $this->setError('No MX record was found for this email');
        }
        return (bool) $result;
    }
}
