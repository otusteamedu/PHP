<?php

namespace Otushw\ServerAPI\Router;

class RouteCollection
{
    private $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add(string $path, string $method, string $controller, string $action): void
    {
        $this->addRoute(new Route($path, $method, $controller, $action));
    }

//    public function any($name, $pattern, $handler, array $tokens = []): void
//    {
//        $this->addRoute(new RegexpRoute($name, $pattern, $handler, [], $tokens));
//    }
//
//    public function get($name, $pattern, $handler, array $tokens = []): void
//    {
//        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens));
//    }
//
//    public function post($name, $pattern, $handler, array $tokens = []): void
//    {
//        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens));
//    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
