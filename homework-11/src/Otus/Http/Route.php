<?php


namespace Otus\Http;


class Route
{
    private string $method;

    private string $uri;

    private array $action;

    public function __construct(string $method, string $uri, array $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function controllerClass()
    {
        return new $this->action[0];
    }

    public function controllerMethod()
    {
        return $this->action[1];
    }

    public static function get(string $uri, array $action): self
    {
        return new self('GET', $uri, $action);
    }

    public static function post(string $uri, array $action): self
    {
        return new self('POST', $uri, $action);
    }

    public static function delete(string $uri, array $action): self
    {
        return new self('DELETE', $uri, $action);
    }
}
