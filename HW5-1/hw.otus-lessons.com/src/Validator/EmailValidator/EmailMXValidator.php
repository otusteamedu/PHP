<?php


namespace Validator\EmailValidator;


class EmailMXValidator implements \EmailValidatorInterface
{
    private array $email = [];
    private array $valid_emails = [];

    public function setEmails(array $emails): void
    {
        $this->email = $emails;
    }

    public function validate(): array
    {
        $this->validateWidthMS();
        return $this->valid_emails;
    }

    private function validateWidthMS()
    {
        $valid_emails = [];
        foreach ($this->valid_emails as $email) {
            $mod_email = str_replace('@', '.', $email);
            if (!empty(dns_get_record($mod_email, DNS_MX))) {
                $valid_emails[] = $email;
            }
        }

        $this->valid_emails = $valid_emails;
    }
}