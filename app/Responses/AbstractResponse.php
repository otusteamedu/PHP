<?php

namespace App\Responses;

class AbstractResponse
{
    /**
     * @var int
     */
    protected int $httpStatusCode;

    /**
     * @var string
     */
    protected string $httpStatusMessage;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->httpStatusMessage;
    }
}
