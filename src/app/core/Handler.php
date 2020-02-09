<?php

namespace Core;

class Handler
{
    private string $method = 'GET';
    private string $requestStr = '';
    private string $contentType = '';
    private $function;

    /**
     * Handler constructor.
     * @param string        $requestStr
     * @param string        $method
     * @param callable|null $handler
     */
    public function __construct(
        string $requestStr,
        string $method = 'GET',
        ?callable $handler = null
    ) {
        $this->function = $handler;
        $this->method = $method;
        $this->requestStr = $requestStr;
    }

    public function __invoke()
    {
        Router::addReqHandler($this);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Handler
     */
    public function setMethod(string $method): Handler
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestStr(): string
    {
        return $this->requestStr;
    }

    /**
     * @param string $requestStr
     * @return Handler
     */
    public function setRequestStr(string $requestStr): Handler
    {
        $this->requestStr = $requestStr;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return Handler
     */
    public function setContentType(string $contentType): Handler
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return callable
     */
    public function getFunction(): callable
    {
        return $this->function;
    }

    /**
     * @param callable $function
     * @return Handler
     */
    public function setFunction(callable $function)
    {
        $this->function = $function;
        return $this;
    }
}