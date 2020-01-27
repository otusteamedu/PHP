<?php

declare(strict_types=1);

namespace Socket\Ruvik\DTO;

class InputArgs
{
    private string $route;
    private string $message;
    private string $env;

    public function __construct(string $route, string $message)
    {
        $this->route = $route;
        $this->env = (string)strstr($route, '/', true);
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }
}
