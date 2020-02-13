<?php

namespace App\Core;

class Request
{
    private string $requestStr = '';
    private array $headers = [];
    private string $body = '';
    private array $filter = [];

    /**
     * Request constructor.
     * @param string|null $requestStr
     */
    public function __construct(?string $requestStr = null)
    {
        $this->requestStr = $requestStr ?? str_replace(
                "?{$_SERVER['QUERY_STRING']}",
                '',
                $_SERVER['REQUEST_URI']
            );
        $this->body = file_get_contents('php://input');
        $this->filter = $_GET ?? [];
        $this->buildHeaders();
    }

    /**
     * @return string
     */
    public function getRequestStr(): string
    {
        return $this->requestStr;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    private function buildHeaders()
    {
        $this->headers = array_intersect_key(
            $_SERVER,
            array_flip(preg_grep('/^HTTP_/', array_keys($_SERVER), 0))
        );
    }
}