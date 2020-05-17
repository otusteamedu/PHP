<?php

namespace Framework\Middleware;

use Aura\Router\RouterContainer;
use Framework\Pipeline\EmptyHandler;
use Framework\Router\HandlerResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMatcherMiddleware implements MiddlewareInterface
{
    /** @var \Aura\Router\RouterContainer */
    private $router;

    /** @var \Framework\Router\HandlerResolver */
    private $resolver;

    /**
     * @param \Aura\Router\RouterContainer $router
     * @param \Framework\Router\HandlerResolver $resolver
     */
    public function __construct(RouterContainer $router, HandlerResolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $matcher = $this->router->getMatcher();
        if (($route = $matcher->match($request)) !== false) {
            $action = $this->resolver->resolve($route->handler);
            return $action->process($request, new EmptyHandler());
        }

        return $handler->handle($request);
    }
}
