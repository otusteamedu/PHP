<?php

namespace Otus\Http;

use JsonException;

class Request
{
    /** @var null|array|mixed */
    private $data;

    public function __construct()
    {
        $this->data = $this->data();
    }

    public static function capture(): self
    {
        return new self();
    }

    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function data(string $key = null)
    {
        if ($this->isForm()) {
            return $this->formData($key) + $_GET;
        }

        if ($this->isJson()) {
            return $this->json($key) + $_GET;
        }

        return $_GET;
    }

    public function isForm(): bool
    {
        if (! array_key_exists('CONTENT_TYPE', $_SERVER)) {
            return false;
        }

        if ($_SERVER['CONTENT_TYPE'] !== 'application/x-www-form-urlencoded') {
            return false;
        }

        return true;
    }

    public function isJson(): bool
    {
        if (! array_key_exists('CONTENT_TYPE', $_SERVER)) {
            return false;
        }

        if (mb_strpos($_SERVER['CONTENT_TYPE'], 'json') === false) {
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
            return $_POST;
        }

        if (array_key_exists($key, $_POST)) {
            return $_POST[$key];
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
        return array_key_exists($key, $this->data);
    }

    public function get(string $key, $default = '')
    {
        if (! $this->has($key)) {
            return $default;
        }

        return $this->data[$key];
    }
}
