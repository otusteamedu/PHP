<?php

namespace EmailVerifier;

use EmailVerifier\Checker\CheckerInterface;
use EmailVerifier\Exceptions\EmailIsNotExists;
use EmailVerifier\Exceptions\EmailIsNotValid;
use EmailVerifier\Validator\ValidatorInterface;

/**
 * Class EmailVerifier
 * @package EmailVerifier
 */
class EmailVerifier
{
    /**
     * @var CheckerInterface
     */
    private $existenceChecker;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $emailValidator, CheckerInterface $emailChecker)
    {
        $this->validator = $emailValidator;
        $this->existenceChecker = $emailChecker;
    }

    /**
     * @param string $email
     * @return bool
     * @throws EmailIsNotExists
     * @throws EmailIsNotValid
     */
    public function isCorrect(string $email): bool
    {
        if(!$this->validator->validate($email)) {
            throw new EmailIsNotValid();
        }

        if(!$this->existenceChecker->exists($email)) {
            throw new EmailIsNotExists();
        }

        return true;
    }
}