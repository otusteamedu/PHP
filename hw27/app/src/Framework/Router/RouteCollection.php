<?php

declare(strict_types=1);

namespace App\Framework\Router;

class RouteCollection
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    public function get(string $uri, array $handler): void
    {
        $this->addRoute(new Route($uri, $handler, ['GET']));
    }

    public function post(string $uri, array $handler): void
    {
        $this->addRoute(new Route($uri, $handler, ['POST']));
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }
}