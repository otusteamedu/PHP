<?php


namespace Otus\Http;


class Router
{
    /** @var \Otus\Http\Route[] */
    private array $routes = [];

    private Request $request;

    public function __construct()
    {
        $this->loadRoutes();
        $this->request = Request::capture();
    }

    public function handle(): Response
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

    private function loadRoutes()
    {
        $this->routes = require __DIR__ . '/../../../routes/web.php';
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
