<?php

namespace App\Core;

class ClientResponse
{
    public const CONTENT_TYPE_TEXT = 'text/plain';
    public const CONTENT_TYPE_HTML = 'text/html';
    public const CONTENT_TYPE_JSON = 'application/json';

    private int $statusCode = 200;
    private string $contentType = self::CONTENT_TYPE_TEXT;
    private array $headers = [];
    private string $body = '';

    /**
     * AppResponse constructor.
     * @param string|null $body
     * @param int|null    $statusCode
     * @param array|null  $headers
     */
    public function __construct(
        ?string $body = '',
        ?int $statusCode = 200,
        ?array $headers = []
    ) {
        $this->body = $body;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    /**
     * @param int|null $code
     * @return string
     */
    public function flush(?int $code = null): string
    {
        if (!headers_sent()) {
            header('HTTP/1.1 ' . ($code ?? $this->statusCode));
            header("Content-Type: {$this->contentType}; charset=utf-8");
            header('Access-Control-Allow-Origin: *');
            foreach ($this->headers as $header) {
                header($header);
            }
        }
        return $this->body;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     * @return ClientResponse
     */
    public function setStatusCode(?int $statusCode): ClientResponse
    {
        $this->statusCode = $statusCode;
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
     * @return ClientResponse
     */
    public function setContentType(string $contentType): ClientResponse
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @param array|null $headers
     * @return ClientResponse
     */
    public function setHeaders(?array $headers): ClientResponse
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return ClientResponse
     */
    public function write(string $body): ClientResponse
    {
        $this->body .= $body;
        return $this;
    }

    /**
     * @return ClientResponse
     */
    public function clear(): ClientResponse
    {
        $this->body = '';
        $this->headers = [];
        return $this;
    }
}