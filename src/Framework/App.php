<?php

namespace Framework;

use Aura\Router\RouterContainer;
use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Pipeline\EmptyHandler;
use Framework\Router\HandlerResolver;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;

class App
{
    /** @var \Aura\Router\RouterContainer */
    private $router;

    /**
     * @param \Aura\Router\RouterContainer $router
     */
    public function __construct(RouterContainer $router)
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
