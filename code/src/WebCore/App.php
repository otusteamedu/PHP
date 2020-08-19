<?php

namespace Penguin\WebCore;

class App
{
    public function run() : void
    {
        $route = new Router();
        [$controllerName, $method] = $route->validate();

        $controller = new $controllerName();
        $controller->$method();
    }
}