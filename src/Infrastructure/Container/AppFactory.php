<?php

namespace Infrastructure\Container;

use Framework\App;
use Framework\Pipeline\HandlerResolver;
use Framework\Pipeline\NotFoundHandler;
use Psr\Container\ContainerInterface;

class AppFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new App(
            $container->get(HandlerResolver::class),
            $container->get(NotFoundHandler::class)
        );
    }
}
