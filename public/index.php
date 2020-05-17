<?php

use App\Controller\BillingController;
use App\Controller\SiteController;
use Aura\Router\RouterContainer;
use Framework\App;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    $router = new RouterContainer();
    $map = $router->getMap();
    $map->get('home', '/', SiteController::class);
    $map->get('paid', '/paid', BillingController::class . '::paid');

    $app = new App($router);
    $app->run();
})();
