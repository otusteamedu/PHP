<?php

namespace Otushw\ServerAPI\Router;

class RouteCollection
{
    private array $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add(string $path, string $method, string $controller, string $action): void
    {
        $this->addRoute(new Route($path, $method, $controller, $action));
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
