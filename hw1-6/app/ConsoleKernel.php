<?php

namespace App;

use Exception;

class ConsoleKernel
{
    /**
     * @var array
     */
    protected array $routes;

    /**
     * ConsoleKernel constructor.
     */
    public function __construct()
    {
        $this->routes = consoleRoutes();
    }

    /**
     * @param $argv
     *
     * @throws Exception
     */
    public function run($argv)
    {
        $route = $this->evaluateRoute($argv[1]);
        $response = $this->instantiateController($route);
    }
    /**
     * @param string $argument
     *
     * @return false|string[]
     *
     * @throws Exception
     */
    protected function evaluateRoute(string $argument)
    {
        if (isset($this->routes[$argument])) {
            return explode('@', $this->routes[$argument]);
        }

        throw new Exception ('No such console route!');
    }

    /**
     * @param array $route
     *
     * @return mixed
     */
    protected function instantiateController(array $route)
    {
        $controller = "App\Controllers\\{$route[0]}";
        $method = $route[1];

        return (new $controller)->$method();
    }
}
