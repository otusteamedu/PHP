<?php

namespace Infrastructure\Container;

use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Pipeline\HandlerResolver;
use Framework\Pipeline\NotFoundHandler;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;

class RouteMatcherMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RouteMatcherMiddleware(
            $container->get(Router::class),
            $container->get(HandlerResolver::class),
            $container->get(NotFoundHandler::class),
        );
    }
}
