<?php
// app/Provider/CommandProvider.php

namespace App\Provider;

use App\Command\RouteListCommand;
use App\Support\CommandMap;
use App\Support\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use Slim\Interfaces\RouteCollectorInterface;
use UltraLite\Container\Container;

class CommandProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        /*
         * Добавим команду списка маршрутов в контейнер
         */
        $container->set(RouteListCommand::class, function (ContainerInterface $container) {
            return new RouteListCommand($container->get(RouteCollectorInterface::class));
        });

        /*
         * Добавим команду списка маршрутов в маппинг команд
         */
        $container->get(CommandMap::class)->set(RouteListCommand::NAME, RouteListCommand::class);
    }
}