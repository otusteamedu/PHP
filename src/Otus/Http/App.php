<?php

namespace Otus\Http;

final class App
{
    private $routes = '';

    public function __construct()
    {
        $this->routes = include(ROOT . '/config/routes.php');
    }

    public function run()
    {
        $this->dispatch();
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        if (!empty($_SERVER['PATH_INFO'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }

        if (!empty($_SERVER['QUERY_STRING'])) {
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }

    private function dispatch()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $pattern => $route) {
            if (preg_match("~$pattern~", $uri)) {

                $internalRoute = preg_replace("~$pattern~", $route, $uri);

                $segments = explode('/', $internalRoute);

                $controller = ucfirst(array_shift($segments)) . 'Controller';

                $action = array_shift($segments);

                $parameters = $segments;

                $controller = 'Otus\\Http\\Controllers\\' . $controller;

                if (!class_exists($controller)) {
                    echo 'error 404';
                    http_response_code(404);
                    return;
                }

                $controllerObj = new $controller;

                if (!method_exists($controllerObj, $action)) {
                    echo 'error 404';
                    http_response_code(404);
                    return;
                }

                $controllerObj->$action($parameters);
            }
        }
    }
}