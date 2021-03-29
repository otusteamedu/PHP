<?php


namespace App\Core;

use App\Controllers\HomeController;

class Router
{
    private Request $request;
    private array $routes;
    private const DEFAULT_CONTROLLER = HomeController::class;
    private const DEFAULT_ACTION = 'pageNotFound';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = include('routes.php');
    }

    public function getResponse() : Response
    {
        $route = null;
        $controller = null;
        $action = null;
        $uri = $this->request->getRequestUri();
        if($this->request->isGet()){
            $route = $this->getGetRoute($uri);
        } else if ($this->request->isPost()) {
            $route = $this->getPostRoute($uri);
        }

        if(is_array($route)){
            [$controller, $action] = $route;
        } else {
            $controller = self::DEFAULT_CONTROLLER;
            $action = self::DEFAULT_ACTION;
        }

        return new Response($controller, $action);
    }

    private function getGetRoute(string $uri) : ? array
    {
        $routes = $this->routes[Request::GET_METHOD];

        return $routes[$this->parseRoute($uri)] ?? null;
    }

    private function getPostRoute(string $uri) : ? array
    {
        $routes = $this->routes[Request::POST_METHOD];

        return $routes[$this->parseRoute($uri)] ?? null;
    }

    private function parseRoute(string $uri) : string
    {
        $requestUri = str_replace($this->request->getQueryString(), '', $uri);

        return trim($requestUri, '?');
    }
}