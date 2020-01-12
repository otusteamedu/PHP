<?php
// app/Provider/WebProvider.php

namespace App\Provider;

use App\Controller\CheckResultController;
use App\Controller\HomeController;
use App\Support\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Twig\Environment;
use UltraLite\Container\Container;

class WebProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        /*
         * Зарегистрируем контроллеры
         */

        $container->set(HomeController::class, function (ContainerInterface $container) {
            return new HomeController($container->get(Environment::class));
        });
        $container->set(CheckResultController::class, function (ContainerInterface $container) {
            return new CheckResultController($container->get(Environment::class));
        });

        /*
         * Зарегистрируем маршруты
         */
        $router = $container->get(RouteCollectorInterface::class);
        $router->group('/', function(RouteCollectorProxyInterface $router) {
            $router->get('', HomeController::class . ':show');
            $router->post('check', CheckResultController::class . ':show');
        });
    }
}