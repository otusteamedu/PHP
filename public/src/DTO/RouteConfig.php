<?php

declare(strict_types=1);

namespace Socket\Ruvik\DTO;

class RouteConfig
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
