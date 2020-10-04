<?php

namespace Otus\Http;

use Otus\Http\Parsers\ParserContract;

class Request
{
    /** @var null|array|mixed */
    private $data;

    public function __construct(ParserContract $parser)
    {
        $this->data = $parser->parse();
    }

    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key = null, $default = '')
    {
        if (! $key) {
            return $this->data;
        }

        if (! $this->has($key)) {
            return $default;
        }

        return $this->data[$key];
    }
}
