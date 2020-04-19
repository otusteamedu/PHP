<?php

use Bjlag\Controllers;

return function (\League\Route\Router $router) {
    $router->map('GET', '/', [Controllers\SiteController::class, 'indexAction']);
};
