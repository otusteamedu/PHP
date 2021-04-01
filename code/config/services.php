<?php


use App\Services\Orm\ModelManager;
use App\Utils\DatabaseConfiguration;
use App\Utils\DatabaseConnection;
use Psr\Container\ContainerInterface;


return [
    DatabaseConnection::class => function(ContainerInterface $container) {
        return new DatabaseConnection($container->get(DatabaseConfiguration::class));
    },
    ModelManager::class => function (ContainerInterface $container) {
        return new ModelManager($container->get(DatabaseConnection::class));
    },
];
