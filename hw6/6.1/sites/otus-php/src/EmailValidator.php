<?php

declare(strict_types=1);

namespace App\Validators;

class EmailValidator
{
    public $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;

        $this->validateAddresses()->validateDomains();

        return empty($this->getEmails()) ? [] : $this->getEmails();
    }

    public function validateAddresses(): self
    {
        if (!empty($this->emails)) {
            $emailPattern = '/^([\w.+-_]+)@([^.][\w.-]*\.[\w-]{2,10})$/iu';

            foreach ($this->emails as $key => $email) {
                if (!preg_match($emailPattern, $email)) {
                    unset($this->emails[$key]);
                    continue;
                }
            }
        }

        return $this;
    }

    public function validateDomains(): self
    {
        if (!empty($this->emails)) {
            foreach ($this->emails as $key => $email) {
                $startDomainPos = strrpos($email, '@') + 1;
                if (!$startDomainPos) {
                    unset($this->emails[$key]);
                    continue;
                }

                $endDomainPos = strlen($email) - 1;
                $asciiDomain = idn_to_ascii(substr($email, $startDomainPos, $endDomainPos));
                if (!checkdnsrr($asciiDomain, 'MX')) {
                    unset($this->emails[$key]);
                    continue;
                }
            }
        }

        return $this;
    }

    public function getEmails()
    {
        return empty($result) ? null : $result;
    }
}

