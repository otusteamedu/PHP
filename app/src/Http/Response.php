<?php


namespace Http;


class Response
{
    /** @var int */
    protected $code;

    /** @var array */
    protected $request;

    /** @var string */
    protected $contentType = "text/plain";

    public function __construct($request = '', $code = 200)
    {
        $this->request = $request;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * @param string $request
     */
    public function setRequest(string $request): void
    {
        $this->request = $request;
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
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    public function send()
    {
        http_response_code($this->code);
        echo $this->request;
    }
}