<?php

namespace App\Http\Response;

use App\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;

    private $headers;
    private $content;
    private $version;
    private $statusCode;

    /**
     * @param int $statusCode
     * @param array $headers
     * @param string $content
     */
    public function __construct(int $statusCode = self::HTTP_OK, array $headers = [], $content = '') {
        $this->headers = $headers;
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->version = '1.1';
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->headers;
    }

    public function getContent() {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return $this->statusCode;
    }
}