<?php

namespace Infrastructure\Container;

use Framework\Pipeline\HandlerResolver;
use Psr\Container\ContainerInterface;

class HandlerResolverFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new HandlerResolver($container);
    }
}
