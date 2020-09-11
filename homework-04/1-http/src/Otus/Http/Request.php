<?php

namespace Otus\Http;

class Request
{
    private array $post;

    private array $server;

    public function __construct()
    {
        $this->post = $_POST;
        $this->server = $_SERVER;
    }

    public static function capture(): self
    {
        return new self();
    }

    public function uri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->post);
    }

    public function get(string $key, $default = '')
    {
        if (! $this->has($key)) {
            return $default;
        }

        return $this->post[$key];
    }
}
