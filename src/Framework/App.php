<?php

namespace Framework;

use Framework\Pipeline\EmptyHandler;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;

class App
{
    /** @var \Laminas\Stratigility\MiddlewarePipe */
    private $pipeline;

    public function __construct()
    {
        $this->pipeline = new MiddlewarePipe();
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $response = $this->pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }

    public function pipe(MiddlewareInterface $middleware): void
    {
        $this->pipeline->pipe($middleware);
    }
}
