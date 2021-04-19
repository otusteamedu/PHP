<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return FrameworkBundle[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
        ];
    }

    /**
     * @param ContainerConfigurator $container
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(__DIR__.'/../config/services.yaml');
    }

    /**
     * @param RoutingConfigurator $routes
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__.'/../config/routes.yaml');
    }
}
