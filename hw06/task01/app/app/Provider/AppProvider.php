<?php
// app/Provider/AppProvider.php

namespace App\Provider;

use App\Support\CommandMap;
use App\Support\Config;
use App\Support\NotFoundHandler;
use App\Support\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Interfaces\RouteResolverInterface;
use Slim\Middleware\ErrorMiddleware;
use Slim\Middleware\RoutingMiddleware;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Routing\RouteCollector;
use Slim\Routing\RouteResolver;
use Twig\Environment;
use UltraLite\Container\Container;

class AppProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {

        /*
         * Регистрируем маппинг консольных команд
         */
        $container->set(CommandMap::class, function () {
            return new CommandMap();
        });

        /*
         * Регистрируем фабрику http-запроса
         */
        $container->set(ResponseFactory::class, function () {
            return new ResponseFactory();
        });

        /*
         * Связываем интерфейс фабрики http-запроса с реализацией
         */
        $container->set(ResponseFactoryInterface::class, function (ContainerInterface $container) {
            return $container->get(ResponseFactory::class);
        });

        /*
         * Регистрируем обработчик вызываемых методов
         */
        $container->set(CallableResolver::class, function (ContainerInterface $container) {
            return new CallableResolver($container);
        });

        /*
         * Связываем интерфейс обработчика вызываемых методов с реализацией
         */
        $container->set(CallableResolverInterface::class, function (ContainerInterface $container) {
            return $container->get(CallableResolver::class);
        });

        /*
         * Регистрируем роутер
         */
        $container->set(RouteCollector::class, function (ContainerInterface $container) {
            $router = new RouteCollector(
                $container->get(ResponseFactoryInterface::class),
                $container->get(CallableResolverInterface::class),
                $container
            );
            return $router;
        });

        /*
         * Связываем интерфес роутера с реализацией
         */
        $container->set(RouteCollectorInterface::class, function (ContainerInterface $container) {
            return $container->get(RouteCollector::class);
        });

        /*
         * Регистрируем обработчик результатов роутера
         */
        $container->set(RouteResolver::class, function (ContainerInterface $container) {
            return new RouteResolver($container->get(RouteCollectorInterface::class));
        });

        /*
         * Связываем интерфес обработчика результатов роутера с реализацией
         */
        $container->set(RouteResolverInterface::class, function (ContainerInterface $container) {
            return $container->get(RouteResolver::class);
        });

        /*
         * Регистрируем обработчика ошибки 404
         */
        $container->set(NotFoundHandler::class, function (ContainerInterface $container) {
            return new NotFoundHandler($container->get(ResponseFactoryInterface::class), $container->get(Environment::class));
        });

        /*
         * Регистрируем middleware обработки ошибок
         */
        $container->set(ErrorMiddleware::class, function (ContainerInterface $container) {
            $middleware = new ErrorMiddleware(
                $container->get(CallableResolverInterface::class),
                $container->get(ResponseFactoryInterface::class),
                $container->get(Config::class)->get('slim.debug'),
                true,
                true);
            $middleware->setErrorHandler(HttpNotFoundException::class, $container->get(NotFoundHandler::class));
            return $middleware;
        });

        /*
         * Регистрируем middleware роутера
         */
        $container->set(RoutingMiddleware::class, function (ContainerInterface $container) {
            return new RoutingMiddleware($container->get(RouteResolverInterface::class));
        });
    }
}