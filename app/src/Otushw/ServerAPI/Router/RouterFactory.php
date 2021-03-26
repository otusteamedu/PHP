<?php


namespace Otushw\ServerAPI\Router;


class RouterFactory
{
    public static function create()
    {
        $routes = new RouteCollection();
        foreach ($_ENV['routes'] as $item) {
            $routes->add($item['path'], $item['method'], $item['controller'], $item['action']);
        }
        return new Router($routes);
    }
}