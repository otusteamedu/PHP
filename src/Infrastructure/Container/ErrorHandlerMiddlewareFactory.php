<?php

namespace Infrastructure\Container;

use App\Middleware\ErrorHandlerMiddleware;
use Psr\Container\ContainerInterface;

class ErrorHandlerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ErrorHandlerMiddleware($container->get('config')['debug']);
    }
}
