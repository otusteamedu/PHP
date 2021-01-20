<?php

namespace ValidationResult;

/**
 * Результат валидации
 *
 * Class ValidationResult
 *
 * @package Validators
 */
class ValidationResult
{
    /**
     * @var string
     */
    private string $subject;
    /**
     * @var string
     */
    private string $status  = '';
    /**
     * @var string
     */
    private string $message = '';

    /**
     * ValidationResult constructor.
     *
     * @param string $subject
     */
    public function __construct (string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject (): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getStatus (): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage (): string
    {
        return $this->message;
    }

    /**
     * @param string $status
     */
    public function setStatus (string $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $message
     */
    public function setMessage (string $message): void
    {
        $this->message = $message;
    }
}
