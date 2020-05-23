<?php

namespace Core;

class Response
{
    /** @var int */
    protected $code;

    /** @var string */
    protected $data;

    /** @var string */
    protected $contentType = "text/plain";

    public function __construct($data = '', $code = 200)
    {
        $this->data = $data;
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
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
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
        header('Content-Type: ' . $this->contentType);
        echo $this->data;
    }
}
