<?php

namespace Validators;

use ValidationResult\ValidationResult;

/**
 * Валидирует email
 *
 * Class EmailValidator
 *
 * @package Validators
 */
class EmailValidator
{
    /**
     * @var string
     */
    private string $email;

    /**
     * Паттерн проверки корректности email
     */
    private const EMAIL_CHECK_PATTERN = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';

    /**
     * EmailValidator constructor.
     *
     * @param string $email
     */
    public function __construct (string $email)
    {
        $this->email = trim($email);
    }

    /**
     * @return ValidationResult
     */
    public function validate (): ValidationResult
    {
        $validationResult = new ValidationResult($this->email);

        if ($this->checkIsEmpty() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('empty');
        }
        else if ($this->checkBadPattern() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('wrong email');
        }
        else if ($this->checkBadMx() === true) {
            $validationResult->setStatus('not valid');
            $validationResult->setMessage('wrong MX');
        }
        else {
            $validationResult->setStatus('valid');
            $validationResult->setMessage('OK');
        }

        return $validationResult;
    }

    /**
     * Проверка на пустоту
     *
     * @return bool
     */
    private function checkIsEmpty (): bool
    {
        return $this->email === '';
    }

    /**
     * Проверка по регулярному выражению
     *
     * @return bool
     */
    private function checkBadPattern (): bool
    {
        return !preg_match(self::EMAIL_CHECK_PATTERN, $this->email);
    }

    /**
     * Проверка MX-записи
     *
     * @return bool
     */
    private function checkBadMx (): bool
    {
        $hostname = explode('@', $this->email)[1];

        return !checkdnsrr($hostname, "MX");
    }
}
