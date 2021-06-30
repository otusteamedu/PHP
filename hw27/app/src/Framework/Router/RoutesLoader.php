<?php

declare(strict_types=1);

namespace App\Framework\Router;

use App\Framework\Config\Configuration;
use UnexpectedValueException;

class RoutesLoader
{
    private Configuration $routesConfig;

    public function __construct(Configuration $routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }

    public function load(): RouteCollection
    {
        $routeCollection = new RouteCollection();

        foreach ($this->getHttpMethodNames() as $httpMethodName) {
            if (!$routes = $this->getRoutesByHttpMethod($httpMethodName)) {
                continue;
            }

            foreach ($routes as $routeUri => $routeHandler) {
                $route = new Route($routeUri, explode('::', $routeHandler), [$httpMethodName]);

                $routeCollection->addRoute($route);
            }
        }

        return $routeCollection;
    }

    private function getHttpMethodNames(): array
    {
        return [
            'GET',
            'POST',
        ];
    }

    private function getRoutesByHttpMethod(string $httpMethodName): array
    {
        try {
            return $this->routesConfig->getParam($httpMethodName);
        } catch (UnexpectedValueException $e) {
            return [];
        }
    }
}