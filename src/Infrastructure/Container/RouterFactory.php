<?php

namespace Infrastructure\Container;

use Aura\Router\RouterContainer;
use Framework\Router\AuraRouterAdapter;
use Psr\Container\ContainerInterface;

class RouterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuraRouterAdapter($container->get(RouterContainer::class));
    }
}
