<?php

use App\providerManager;
use App\Providers\RouteProvider;
use App\Providers\ServiceProvider;
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$providerManager = new providerManager();
$providerManager->registerServiceProvider(new ServiceProvider(), $container);
$providerManager->registerRouteProvider(new RouteProvider(), $app);

$app->run();
