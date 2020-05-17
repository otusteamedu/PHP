<?php

namespace Framework;

use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Pipeline\EmptyHandler;
use Framework\Router\HandlerResolver;
use Framework\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;

class App
{
    /** @var \Framework\Router\Router */
    private $router;

    /**
     * @param \Framework\Router\Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $pipeline = new MiddlewarePipe();
        $resolver = new HandlerResolver();

        $pipeline->pipe(new RouteMatcherMiddleware($this->router, $resolver));
        $pipeline->pipe(new NotFoundHandler(function () {
            return new Response();
        }));

        $response = $pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }
}
