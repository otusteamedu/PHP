<?php

namespace Infrastructure\Container\Repository;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class OrderRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new OrderRepository($container->get(EntityManagerInterface::class));
    }
}
