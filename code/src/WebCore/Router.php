<?php


namespace Penguin\WebCore;


class Router
{
    protected array $routes;

    public function __construct()
    {
        $this->routes = [
            '/' => ['IndexController', 'index'],
            '/post' => ['IndexController', 'post']
        ];

    }

    public function validate() : array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        if (!isset($this->routes[$uri])) {
            throw new \Exception(404);
        }

        return [
            'Penguin\Controller\\' . $this->routes[$uri][0],
            $this->routes[$uri][1]
        ];
    }
}