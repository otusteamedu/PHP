<?php

use Aura\Router\RouterContainer;
use Framework\Router\AuraRouterAdapter;
use Framework\Router\HandlerResolver;
use Framework\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            HandlerResolver::class => function (ContainerInterface $container) {
                return new HandlerResolver($container);
            },
            RouterContainer::class => function () {
                return (require 'config/routes.php')();
            },
            Router::class => function (ContainerInterface $container) {
                return new AuraRouterAdapter($container->get(RouterContainer::class));
            },
            NotFoundHandler::class => function () {
                return new NotFoundHandler(function () {
                    return new Response();
                });
            }
        ],
    ],

    'config' => [
    ],
];
