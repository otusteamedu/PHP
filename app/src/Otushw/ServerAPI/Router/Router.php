<?php

namespace Otushw\ServerAPI\Router;

use Psr\Http\Message\ServerRequestInterface;
use Otushw\ServerAPI\Exception\RouterException;

class Router
{
    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function process(ServerRequestInterface $request): ControllerFactory
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($controllerFactory = $route->check($request)) {
                return $controllerFactory;
            }
        }

        throw new RouterException('No route matched');
    }

}
