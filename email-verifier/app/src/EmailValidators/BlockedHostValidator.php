<?php

namespace App\EmailValidators;

use App\AbstractEmailValidator;
use App\EmailHelper;
use App\EmailValidatorException;
use function in_array;


class BlockedHostValidator extends AbstractEmailValidator
{
    private array $blockedHosts;

    public function __construct(array $blockedHosts)
    {
        $this->blockedHosts = $blockedHosts;
    }

    public function validate(string $email): void
    {
        $host = EmailHelper::getHostByEmail($email);

        if (in_array($host, $this->blockedHosts, true)) {
            throw new EmailValidatorException('Данный хост заблокирован');
        }

        parent::validate($email);
    }
}