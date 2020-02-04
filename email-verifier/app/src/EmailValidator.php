<?php

namespace App;

use LogicException;

/**
 * Class EmailValidator
 * @package App
 */
class EmailValidator
{
    /** @var EmailValidatorInterface[] */
    private array $emailValidators = [];

    public array $log = [];

    /**
     * @param string $email
     * @return bool
     */
    public function runOne(string $email): bool
    {
        if (!$this->emailValidators) {
            throw new LogicException('Необходимо добавить как минимум один валидатор');
        }

        foreach ($this->emailValidators as $emailValidator) {
            if ($emailValidator->run($email, $this->log) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $emails
     */
    public function runBatch(array $emails): void
    {
        if (!$this->emailValidators) {
            throw new LogicException('Необходимо добавить как минимум один валидатор');
        }

        foreach ($emails as $email) {
            $this->runOne($email);
        }
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->log;
    }

    /**
     * @param EmailValidatorInterface $emailValidator
     * @return $this
     */
    public function addValidator(EmailValidatorInterface $emailValidator): self
    {
        $this->emailValidators[] = $emailValidator;

        return $this;
    }
}
