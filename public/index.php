<?php

use Framework\App;
use Framework\Router\AuraRouterAdapter;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    $routes = (require 'config/routes.php')();
    $router = new AuraRouterAdapter($routes);
    $app = new App();

    (require 'config/pipeline.php')($app, $router);

    $app->run();
})();
