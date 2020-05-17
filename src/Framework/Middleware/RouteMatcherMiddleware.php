<?php

namespace Framework\Middleware;

use Framework\Pipeline\EmptyHandler;
use Framework\Router\Exception\RouteNotMatchedException;
use Framework\Router\HandlerResolver;
use Framework\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMatcherMiddleware implements MiddlewareInterface
{
    /** @var \Framework\Router\Router */
    private $router;

    /** @var \Framework\Router\HandlerResolver */
    private $resolver;

    /**
     * @param \Framework\Router\Router $router
     * @param \Framework\Router\HandlerResolver $resolver
     */
    public function __construct(Router $router, HandlerResolver $resolver)
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
        try {
            $result = $this->router->match($request);
            $action = $this->resolver->resolve($result->getHandler());
            return $action->process($request, new EmptyHandler());
        } catch (RouteNotMatchedException $e) {
            return $handler->handle($request);
        }
    }
}
