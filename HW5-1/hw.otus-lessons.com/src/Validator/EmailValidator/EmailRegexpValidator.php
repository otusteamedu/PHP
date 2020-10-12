<?php


namespace Validator\EmailValidator;


use Validator\ValidatorInterface;

class EmailRegexpValidator implements \EmailValidatorInterface
{
    private array $valid_emails = [];

    private array $emails = [];

    private array $regexp = [
        '/[0-9a-z]+@[a-zA-Z0-9]+\.[a-zA-Z]+$/',
    ];

    public function setEmails(array $emails) : void
    {
        $this->emails = $emails;
    }

    public function setRegexp(array $regexp)
    {
        $this->regexp = $regexp;
    }

    public function validate(): array
    {
        $this->validateWidthRegexp();
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
}