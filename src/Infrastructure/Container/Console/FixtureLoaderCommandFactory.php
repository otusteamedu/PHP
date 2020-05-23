<?php

namespace Infrastructure\Container\Console;

use App\Console\Command\FixtureLoaderCommand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class FixtureLoaderCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new FixtureLoaderCommand(
            $container->get(EntityManagerInterface::class),
            $container->get('config')['fixture']['dir']
        );
    }
}
