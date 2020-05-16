<?php

namespace Classes\Email\Validator;

class EmailValidatorsServiceImpl implements EmailValidatorsService
{
    private $errors = [];

    public function isValid(string $email): bool
    {
        /** @var EmailValidator $validator */
        foreach ($this->getValidatorsCollection() as $validator) {
           if (!($validator->isValid($email))) {
               $this->errors[] = $validator->getErrorMessage();
           }
       }
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function getValidatorsCollection(): array
    {
        $collection = [];
        /** @var EmailValidator $class */
        foreach (Validators::EMAIL_VALIDATORS_LIST as $class) {
            $collection[] = new $class;
        }

        return $collection;
    }


}
