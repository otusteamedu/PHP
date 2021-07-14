<?php

namespace App\EmailValidator;

use App\AppException;
use App\Request\Request;
use App\Response\Response;

class EmailValidator extends AbstractValidator {

    public const VALIDATOR_NAME = 'EMAIL_VALIDATOR';

    protected function isValidEmail(string $email, $extended = false)
    {
        if (empty($email)) {
            return false;
        }

        if (!preg_match('/^([a-z0-9_\'&\\.\\-\\+])+\\@(([a-z0-9\\-])+\\.)+([a-z0-9]{2,10})+$/i', $email)) {
            return false;
        }

        $domain = substr($email, strrpos($email, '@') + 1);
        $mxhosts = [];

        $checkDomain = getmxrr($domain, $mxhosts);

        if (!$checkDomain || empty($mxhosts)) {
            $dns = dns_get_record($domain, DNS_A);
            if (empty($dns)) {
                return false;
            }
        }

        return true;
    }
}