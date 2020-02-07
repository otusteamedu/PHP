<?php declare(strict_types=1);

namespace Service;

use Controller\ChannelsController;
use Controller\Stats\SumController;
use Controller\Stats\TopController;
use Controller\YoutubeSpiderController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private array $routes = [
        '/\\/channels\\/?[a-zA-Z0-9_\\-]*/' => ChannelsController::class,
        '/\\/stats\\/sum\\/?/' => SumController::class,
        '/\\/stats\\/top\\/?/' => TopController::class,
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

    public function resolveCommand(string $command): callable
    {
        if ($command === 'spider/run') {
            return [new YoutubeSpiderController(), 'runAction'];
        } else {
            throw new Exception("Command {$command} not found");
        }
    }
}
