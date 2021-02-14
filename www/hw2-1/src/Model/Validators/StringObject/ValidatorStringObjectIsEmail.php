<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators\StringObject;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;
use Nlazarev\Hw2_1\Model\Validators\StringObject\ValidatorStringObject;

class ValidatorStringObjectIsEmail extends ValidatorStringObject implements IValidatorStringObjectIsEmail
{
    private ?string $email_user = null;
    private ?string $email_domain = null;

    protected function parseEmail(string $email)
    {
        $arr = explode("@", $email);

        $this->email_user = null;
        $this->email_domain = null;

        if (count($arr) == 2) {
            $this->email_user = $arr[0];
            $this->email_domain = $arr[1];
        }
    }

    protected function isEmailParsed(): bool
    {
        if (is_null($this->email_user) || is_null($this->email_domain)) {
            return false;
        }

        return true;
    }

    protected function isMxDomainExists(): bool
    {
        //icu-dev + php_intl needed
        if (
            !checkdnsrr(idn_to_ascii($this->email_domain), "MX")
            && !checkdnsrr($this->email_domain, "MX")
        ) {
            return false;
        }

        return true;
    }

    public function isStringObjectEmail(IStringObject $string_object): bool
    {
        if (!parent::isValidStringObject($string_object)) {
            return false;
        }

        $this->parseEmail($string_object->getValue());

        if (!$this->isEmailParsed()) {
            return false;
        }

        if (!filter_var($string_object->getValue(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!$this->isMxDomainExists()) {
            return false;
        }

        return true;
    }
}
