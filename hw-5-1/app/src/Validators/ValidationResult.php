<?php

namespace Validators;

class ValidationResult
{
    private string $subject;
    private string $status = '';
    private string $message = '';

    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
