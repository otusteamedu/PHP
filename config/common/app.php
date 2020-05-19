<?php

use App\Middleware\ErrorHandlerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Pipeline\HandlerResolver;
use Framework\Router\Router;
use Infrastructure\Container;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            HandlerResolver::class => Container\HandlerResolverFactory::class,
            RouterContainer::class => Container\RouterContainerFactory::class,
            Router::class => Container\RouterFactory::class,
            ErrorHandlerMiddleware::class => Container\ErrorHandlerMiddlewareFactory::class,
            NotFoundHandler::class => Container\NotFoundHandlerFactory::class
        ],
    ],

    'config' => [
        'debug' => false
    ],
];
