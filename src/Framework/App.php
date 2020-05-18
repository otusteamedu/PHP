<?php

namespace Framework;

use Framework\Pipeline\EmptyHandler;
use Framework\Router\HandlerResolver;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;

class App
{
    /** @var \Framework\Router\HandlerResolver */
    private $resolver;

    /** @var \Laminas\Stratigility\MiddlewarePipe */
    private $pipeline;

    /**
     * @param \Framework\Router\HandlerResolver $resolver
     */
    public function __construct(HandlerResolver $resolver)
    {
        $this->resolver = $resolver;
        $this->pipeline = new MiddlewarePipe();
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $response = $this->pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }

    /**
     * @param mixed $middleware
     */
    public function pipe($middleware): void
    {
        $this->pipeline->pipe($this->resolver->resolve($middleware));
    }
}
