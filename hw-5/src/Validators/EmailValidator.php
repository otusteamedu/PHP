<?php


namespace AAntonov\Validators;


use AAntonov\Validators\Contracts\ValidatorInterface;

class EmailValidator extends BaseValidator
{

    protected array $errors = [];

    public function validate()
    {
        if (!$this->validateByRule(new NotNullValidator($this->field))) {
            return false;
        }

        if (!$this->validateByRule(new EmailRegExpValidator($this->field))) {
            return false;
        }

        if (!$this->validateByRule(new EmailMxValidator($this->field))) {
            return false;
        }

        return true;
    }

    /**
     * @param ValidatorInterface $validator
     * @return bool
     */
    private function validateByRule(ValidatorInterface $validator): bool
    {
        if (!$validator->validate()) {
            $this->errors[] = $validator->getFirstError();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
