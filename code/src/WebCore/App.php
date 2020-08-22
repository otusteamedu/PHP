<?php

namespace Penguin\WebCore;

use Dotenv\Dotenv;

class App
{
    public function run() : void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $route = new Router();
        [$controllerName, $method] = $route->validate();

        $controller = new $controllerName();
        $controller->$method();
    }
}