<?php


namespace Otus\Http;


use Otus\Exceptions\FileNotFound;
use Throwable;

class Router
{
    /** @var \Otus\Http\Route[] */
    private array $routes = [];

    private Request $request;

    public function __construct(string $path)
    {
        $this->loadRoutes($path);
        $this->request = RequestFactory::make();
    }

    public function handle(): ResponseContract
    {
        foreach ($this->routes as $route) {
            if (! $this->matches($route, $this->request)) {
                continue;
            }

            return call_user_func([
                $route->controllerClass(),
                $route->controllerMethod()
            ], $this->request);
        }

        return new Response(Response::HTTP_NOT_FOUND);
    }

    private function loadRoutes(string $path): void
    {
        $routesPath = $path . 'routes/web.php';

        if (! file_exists($routesPath)) {
            throw new FileNotFound();
        }

        $this->routes = require $routesPath;
    }

    public function addRoute(string $method, string $uri, array $action): self
    {
        $this->routes[] = new Route($method, $uri, $action);

        return $this;
    }

    private function matches(Route $route, Request $request): bool
    {
        return $route->method() === $request->method() && $route->uri() === $request->uri();
    }
}
