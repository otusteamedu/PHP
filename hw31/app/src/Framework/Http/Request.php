<?php

declare(strict_types=1);

namespace App\Framework\Http;

class Request implements RequestInterface
{
    private array $attributes = [];

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUriPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function getPostParam($paramName): string
    {
        return $_POST[$paramName] ?? '';
    }

    public function withAttributes(array $attrs)
    {
        $this->attributes = array_merge($this->attributes, $attrs);
    }

    public function withAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute($name)
    {
        return (array_key_exists($name, $this->attributes) !== false ? $this->attributes[$name] : null);
    }
}