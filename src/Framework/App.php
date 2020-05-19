<?php

namespace Framework;

use Framework\Pipeline\HandlerResolver;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\RequestHandlerInterface;

class App
{
    /** @var \Framework\Pipeline\HandlerResolver */
    private $resolver;

    /** @var \Laminas\Stratigility\MiddlewarePipe */
    private $pipeline;

    /** @var \Psr\Http\Server\RequestHandlerInterface */
    private $defaultHandler;

    /**
     * @param \Framework\Pipeline\HandlerResolver $resolver
     * @param \Psr\Http\Server\RequestHandlerInterface $defaultHandler
     */
    public function __construct(HandlerResolver $resolver, RequestHandlerInterface $defaultHandler)
    {
        $this->resolver = $resolver;
        $this->defaultHandler = $defaultHandler;
        $this->pipeline = new MiddlewarePipe();
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $response = $this->pipeline->process($request, $this->defaultHandler);

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
