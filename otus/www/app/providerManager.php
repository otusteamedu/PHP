<?php

namespace App;

use App\Providers\RouteProvider;
use App\Providers\ServiceProvider;
use DI\Container;
use Slim\App;


class providerManager
{

    public function registerRouteProvider(RouteProvider $provider, App $app): void
    {
        $provider->register($app);
    }

    public function registerServiceProvider(ServiceProvider $provider, Container $container): void
    {
        $provider->register($container);
    }
}
