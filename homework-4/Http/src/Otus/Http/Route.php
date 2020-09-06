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
        return $this->action[0];
    }

    public function controllerMethod()
    {
        return $this->action[1];
    }
}
