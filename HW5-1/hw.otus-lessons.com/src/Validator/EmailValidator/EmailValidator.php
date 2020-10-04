<?php


namespace Validator\EmailValidator;


final class EmailValidator implements \Validator\ValidatorInterface
{
    private array $regexp = [
        '/[0-9a-z]+@[a-zA-Z0-9]+\.[a-zA-Z]+$/',
    ];

    private array $valid_emails = [];

    private array $emails = [];

    public function setRegexps(array $regexp)
    {
        $this->regexp = $regexp;
        return $this;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
        return $this;
    }

    final public function validate() : array
    {
        $this->emails = array_unique($this->emails);
        $this->validateWidthRegexp();
        $this->validateWidthMS();

        return $this->valid_emails;
    }

    private function validateWidthRegexp()
    {
        foreach ($this->emails as $email) {
            foreach ($this->regexp as $regexp) {
                if (preg_match($regexp, $email)) {
                    $this->valid_emails[] = $email;
                    break;
                }
            }
        }
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