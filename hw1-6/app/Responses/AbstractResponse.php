<?php

namespace App\Responses;

abstract class AbstractResponse
{
    /**
     * @var string
     */
    protected string $nodeIP;
    /**
     * @var int
     */
    protected int $httpStatusCode;

    /**
     * @var string
     */
    protected string $httpStatusMessage;

    /**
     * AbstractResponse constructor.
     */
    public function __construct()
    {
        $this->setNodeIP();
    }

    /**
     * @return string
     */
    public function getNodeIP(): string
    {
        return $this->nodeIP;
    }

    /**
     * @return void
     */
    public function setNodeIP()
    {
        $this->nodeIP = gethostbyname(gethostname());
    }

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
