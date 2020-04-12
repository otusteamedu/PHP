<?php

use Bjlag\Controllers\SiteController;

return function (\League\Route\Router $router) {
    $router->map('GET', '/', [SiteController::class, 'indexAction']);
};
