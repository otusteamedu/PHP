<?php

namespace Infrastructure\Container\Controller;

use App\Controller\BillingController;
use App\Repository\OrderRepository;
use App\Service\AServiceAdapter;
use Psr\Container\ContainerInterface;

class BillingControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new BillingController(
            $container->get(AServiceAdapter::class),
            $container->get(OrderRepository::class),
        );
    }
}
