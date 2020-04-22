<?php


namespace Service;

use Controller\ChannelController;
use Controller\EventController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class Router
{

    private $routes = [
        '/\/task1\/channels\/(add|find|channel|delete|summary|top)[a-zA-Z0-9_\/-]*/' => ChannelController::class,
        '/\/task2\/event\/(add|find|clear)[a-zA-Z0-9_\/-]*/' => EventController::class,
    ];

    public function dispatch(Request $request)
    {
        $path = $request->getPathInfo();
        foreach ($this->routes as $route => $controller) {

            if (preg_match($route, $path) &&
                method_exists($controller, $method = explode('/', $path)[3])) {
                return [new $controller, $method];
            }
        }

        throw new Exception('Bad request', Response::HTTP_BAD_REQUEST);
    }
}