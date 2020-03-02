<?php

namespace App\EmailValidator;

use LogicException;

final class EmailValidator
{
    private string $error = '';

    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $email
     * @param string[] $val_names
     * @return bool
     * @throws LogicException
     */
    public function isValid(string $email, array $val_names = [RegexValidation::class]): bool
    {
        $this->reset();
        foreach ($val_names as $val_name) {
            if (!class_exists($val_name) || !is_subclass_of($val_name, EmailValidation::class)) {
                throw new LogicException("Validator $val_name not exists");
            }
            $validator = new $val_name();
            if (!$this->check($email, $validator)) {
                return false;
            }
        }
        return true;
    }

    private function reset(): void
    {
        $this->error = '';
    }

    /**
     * @param string $email
     * @param EmailValidation $validator
     * @return bool
     */
    private function check(string $email, EmailValidation $validator): bool
    {
        $result = $validator->isValid($email);
        $this->error = $validator->getError();
        return $result;
    }
}
