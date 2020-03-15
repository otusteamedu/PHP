<?php declare(strict_types=1);

namespace Service;

use Controller\Shop\OrdersController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private array $routes = [
        '/\\/shop\\/orders\\/?[a-zA-Z0-9_\\-]*/' => OrdersController::class,
    ];

    public function handleRequest(Request $request): callable
    {
        $method = strtolower($request->getMethod());
        $path = $request->getPathInfo();

        $method .= 'Action';
        foreach ($this->routes as $route => $controller) {
            if (preg_match($route, $path) && method_exists($controller, $method)) {
                return [new $controller, $method];
            }
        }

        throw new Exception('Bad request', Response::HTTP_BAD_REQUEST);
    }
}
