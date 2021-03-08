<?php

namespace App;

use App\Exceptions\NoSuchHttpRoute;
use App\Responses\AbstractResponse;
use App\Controllers\HomeController;

class HttpKernel
{
    /**
     * Routes table.
     *
     * @var string[]
     */
    protected array $routes;

    /**
     * HttpKernel constructor.
     */
    public function __construct()
    {
        $this->routes = httpRoutes();
    }

    /**
     * @throws NoSuchHttpRoute
     */
    public function run()
    {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        $route = $this->evaluateRoute($route, $method);
        $response = $this->instantiateController($route, $_REQUEST);
        $this->dispatchResponse($response);
    }

    /**
     * @param string $route
     * @param string $method
     *
     * @return false|string[]
     *
     * @throws NoSuchHttpRoute
     */
    protected function evaluateRoute(string $route, string $method)
    {
        if (isset($this->routes["{$method}@{$route}"])) {
            return explode('@', $this->routes["{$method}@{$route}"]);
        }

        throw new NoSuchHttpRoute();
    }

    /**
     * @param array $route
     * @param array $request
     *
     * @return mixed
     */
    protected function instantiateController(array $route, array $request)
    {
        $controller = "App\Controllers\\{$route[0]}";
        $method = $route[1];

        return (new $controller)->$method($request);
    }

    /**
     * @param AbstractResponse $response
     */
    protected function dispatchResponse(AbstractResponse $response)
    {
        http_response_code($response->getCode());
        echo $response->getMessage();
    }
}
