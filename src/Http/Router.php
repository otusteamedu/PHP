<?php


namespace Src\Http;


class Router
{
    private Request $request;
    private array $routes;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = include('../routes.php');
    }

    public function getResponse() : string
    {
        $uri = $this->request->getRequestUri();
        $route = $this->getRoute($uri);

        if(is_null($route)){
            throw new \RuntimeException('Page not found', 404);
        }

        [$controller, $action] = $route;

        return $this->callAction($controller, $action);
    }

    private function callAction(string $controller, string $action) : string
    {
        if(false === class_exists($controller)){
            throw new \RuntimeException('Controller ' . $controller . ' not exist');
        }

        $controllerObj = new $controller;

        if(false === method_exists($controllerObj, $action)){
            throw new \RuntimeException('Method ' . $action . ' not exist in ' . $controller);
        }

        return call_user_func_array([$controllerObj, $action], [$this->request]);
    }

    private function getRoute(string $uri) : ? array
    {
        return $this->routes[$this->parseRoute($uri)] ?? null;
    }

    private function parseRoute(string $uri) : string
    {
        $requestUri = str_replace($this->request->getQueryString(), '', $uri);

        return trim($requestUri, '?');
    }
}