<?php

declare(strict_types=1);

namespace App\Framework\Router;

use App\Framework\Http\RequestInterface;

class Router
{
    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function match(RequestInterface $request): Route
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Маршрут {$request->getUriPath()} не найден");
    }
}