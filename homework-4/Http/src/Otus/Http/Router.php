<?php


namespace Otus\Http;


class Router
{
    /** @var \Otus\Http\Route[] */
    private array $routes = [];

    public function handle(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if (! $this->matches($route, $request)) {
                continue;
            }

            return call_user_func([
                $route->controllerClass(),
                $route->controllerMethod()
            ], $request);
        }

        return new Response(Response::HTTP_NOT_FOUND);
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
