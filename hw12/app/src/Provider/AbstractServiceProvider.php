<?php

declare(strict_types=1);

namespace App\Provider;

use App\Config\Configuration;
use App\DIContainer\ContainerInterface;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{

    protected array $bindings = [];

    private ContainerInterface $container;
    protected Configuration    $config;

    public final function __construct(Configuration $config, ContainerInterface $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    public final function register(): void
    {
        $this->addMoreBindings();

        foreach ($this->bindings as $abstract => $concreteImpl) {
            $this->container->set($abstract, $concreteImpl);
        }
    }

    abstract protected function addMoreBindings(): void;

}