<?php

use App\Middleware\ErrorHandlerMiddleware;
use Aura\Router\RouterContainer;
use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Pipeline\HandlerResolver;
use Framework\Pipeline\NotFoundHandler;
use Framework\Router\Router;
use Infrastructure\Container;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            App::class => Container\AppFactory::class,
            HandlerResolver::class => Container\HandlerResolverFactory::class,
            RouterContainer::class => Container\RouterContainerFactory::class,
            Router::class => Container\RouterFactory::class,
            RouteMatcherMiddleware::class => Container\RouteMatcherMiddlewareFactory::class,
            ErrorHandlerMiddleware::class => Container\ErrorHandlerMiddlewareFactory::class,
        ],
    ],

    'config' => [
        'debug' => false
    ],
];
