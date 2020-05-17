<?php

use Framework\App;
use Framework\Router\AuraRouterAdapter;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    $router = (require 'config/router.php')();

    $app = new App(new AuraRouterAdapter($router));
    $app->run();
})();
