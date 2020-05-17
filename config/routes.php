<?php

use App\Controller\{
    BillingController,
    SiteController
};
use Aura\Router\RouterContainer;

return function () {
    $router = new RouterContainer();
    $map = $router->getMap();

    $map->get('home', '/', SiteController::class);
    $map->get('paid', '/paid', BillingController::class . '::paid');

    return $router;
};
