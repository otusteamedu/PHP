<?php

namespace Framework\Middleware;

use Framework\Pipeline\HandlerResolver;
use Framework\Router\Exception\RouteNotMatchedException;
use Framework\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMatcherMiddleware implements MiddlewareInterface
{
    /** @var \Framework\Router\Router */
    private $router;

    /** @var \Framework\Pipeline\HandlerResolver */
    private $resolver;

    /** @var \Psr\Http\Server\RequestHandlerInterface */
    private $next;

    /**
     * @param \Framework\Router\Router $router
     * @param \Framework\Pipeline\HandlerResolver $resolver
     * @param \Psr\Http\Server\RequestHandlerInterface $next
     */
    public function __construct(Router $router, HandlerResolver $resolver, RequestHandlerInterface $next)
    {
        $this->router = $router;
        $this->resolver = $resolver;
        $this->next = $next;
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
            return $action->process($request, $this->next);
        } catch (RouteNotMatchedException $e) {
            return $handler->handle($request);
        }
    }
}
