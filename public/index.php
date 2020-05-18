<?php

use Framework\App;
use Framework\Router\HandlerResolver;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require_once 'config/container.php';

    $app = new App($container->get(HandlerResolver::class));

    (require 'config/pipeline.php')($app);

    $app->run();
})();
