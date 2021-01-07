<?php

namespace EmailValidator;

use EmailValidator\Validation\ValidationInterface;

class EmailValidator
{
    /**
     * @var ValidationInterface[]
     */
    private array $validations;

    /**
     * @param ValidationInterface[] $validations
     */
    public function __construct(array $validations)
    {
        $this->validations = $validations;
    }

    public function isValid(string $email): bool
    {
        foreach ($this->validations as $validation) {
            if (false === $validation->isValid($email)) {
                return false;
            }
        }

        return true;
    }
}