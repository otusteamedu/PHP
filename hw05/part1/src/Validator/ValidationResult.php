<?php

namespace App\Validator;

class ValidationResult
{
    /**
     * @var bool
     */
    public $isPassed;
    /**
     * @var string|null
     */
    public $message;

    /**
     * @param bool $isPassed
     * @param string|null $message
     */
    public function __construct(bool $isPassed = true, string $message = null)
    {
        $this->isPassed = $isPassed;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function failed(): bool
    {
        return $this->isPassed === false;
    }
}
