<?php

namespace Otus\Http;

use JsonException;

class Request
{
    private array $post;

    private array $server;

    private array $headers;

    public function __construct()
    {
        $this->post    = $_POST;
        $this->server  = $_SERVER;
        $this->headers = getallheaders();
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

    public function data(string $key = null)
    {
        if ($this->isForm()) {
            return $this->formData($key);
        }

        if ($this->isJson()) {
            return $this->json($key);
        }

        return [];
    }

    public function isForm(): bool
    {
        if (! array_key_exists('Content-Type', $this->headers)) {
            return false;
        }

        if ($this->headers['Content-Type'] !== 'application/x-www-form-urlencoded') {
            return false;
        }

        return true;
    }

    public function isJson(): bool
    {
        if (! array_key_exists('Content-Type', $this->headers)) {
            return false;
        }

        if (mb_strpos($this->headers['Content-Type'], 'json') === false) {
            return false;
        }

        return true;
    }

    public function body()
    {
        $stream = fopen('php://input', 'rb');

        return stream_get_contents($stream);
    }

    public function formData(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }

        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        }

        return $default;
    }

    public function json(string $key = null, $default = null)
    {
        try {
            $data = json_decode($this->body(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        } catch (JsonException $exception) {
            $data = [];
        }

        if ($key === null) {
            return $data;
        }

        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $default;
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
