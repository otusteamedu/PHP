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
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->routes = httpRoutes();
    }

    /**
     * @throws NoSuchHttpRoute
     * @throws Exceptions\NoValidatingRulesForThisRoute
     */
    public function run()
    {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        $route = $this->evaluateRoute($route, $method);
        $validatingRule = rules("{$method}@{$route}");
        $response = $this->instantiateController($route, $_REQUEST, $validatingRule);
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
     * @param array $validatingRule
     *
     * @return mixed
     */
    protected function instantiateController(array $route, array $request, array $validatingRule)
    {
        $controller = "App\Controllers\\{$route[0]}";
        $method = $route[1];

        return (new $controller)->$method($request, $validatingRule);
    }

    /**
     * @param AbstractResponse $response
     */
    protected function dispatchResponse(AbstractResponse $response)
    {
        http_response_code($response->getCode());

        echo sprintf('Node ip is: <strong>%s</strong><hr>', $response->getNodeIP());
        echo $response->getMessage();
    }
}
