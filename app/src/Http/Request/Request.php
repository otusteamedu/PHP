<?php

namespace App\Http\Request;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $method;
    private $url;
    private $parameters;
    private $query;

    /**
     * @param string $method
     * @param string $url
     */
    public function __construct(string $method, string $url) {
        $this->method = $method;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getParameters(): array {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getQuery(): array {
        return $this->query;
    }

    public function setParameters($parameters): void {
        $this->parameters = $parameters;
    }

    public function setQuery($query): void {
        $this->query = $query;
    }
}