<?php

namespace App\EmailValidators;

use App\AbstractEmailValidator;
use App\EmailHelper;
use App\EmailValidatorException;
use function checkdnsrr;


class DNSMXRecordValidator extends AbstractEmailValidator
{
    public function validate(string $email): void
    {
        $hostname = EmailHelper::getHostByEmail($email);

        if (!$hostname || !checkdnsrr($hostname, 'MX')) {
            throw new EmailValidatorException('Email не прошел проверку домена на наличие MX-записи');
        }

        parent::validate($email);
    }
}