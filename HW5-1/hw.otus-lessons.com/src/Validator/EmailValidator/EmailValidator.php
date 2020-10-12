<?php


namespace Validator\EmailValidator;


class EmailValidator implements \Validator\ValidatorInterface
{
    private array $valid_emails = [];

    private array $emails = [];

    private array $validators = [];

    public function __construct(array $email_validators) {
        $this->validators = $email_validators;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
        return $this;
    }

    public function validate() : array
    {
        $this->emails = array_unique($this->emails);
        $this->valid_emails = $this->emails;
        foreach ($this->validators as $validator) {
            /** @var \EmailValidatorInterface $validator */
            $validator->setEmails($this->valid_emails);
            $this->valid_emails = $validator->validate();
        }

        return $this->valid_emails;
    }
}