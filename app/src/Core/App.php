<?php

namespace App\Core;

use App\Config;
use App\Factory\RequestFactory;
use App\Factory\ResponseFactory;
use App\Handlers\ControllerHandler;
use App\Http\Request\Request;
use App\Interfaces\RequestInterface;
use App\Routing\Exceptions\RouteException;
use App\Routing\ResponseEmitter;
use App\Routing\Router;

class App
{
    private $routing;
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config) {
        $this->config = $config;
        $this->routing = new Router($config->get('routes'));
    }

    /**
     * @param Request $request
     */
    private function handle(RequestInterface $request) {
        try {
            $routeConfig = $this->routing->run($request);
            $controllerHandler = new ControllerHandler($routeConfig);
            $content = $controllerHandler->handle();

            return ResponseFactory::createResponse(200, [], $content);
        } catch (RouteException $e) {
            return ResponseFactory::createResponse($e->getCode(), [], $e->getMessage());
        }
    }

    /**
     * @param RequestInterface|null $request
     */
    public function run(RequestInterface $request = null) {
        if (!$request) {
            $request = RequestFactory::createRequestFromGlobals();
        }
        $response = $this->handle($request);
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}