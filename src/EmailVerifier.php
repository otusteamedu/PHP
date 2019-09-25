<?php

namespace EmailVerifier;

use EmailVerifier\Validator\ValidatorInterface;

/**
 * Class EmailVerifier
 * @package EmailVerifier
 */
class EmailVerifier
{

    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    public function addValidator(ValidatorInterface $validator): EmailVerifier
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isCorrect(string $email): bool
    {
        foreach ($this->validators as $validator) {
            $validator->validate($email);
        }

        return true;
    }
}