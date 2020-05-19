<?php

use Framework\App;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

(function () {
    /**
     * @var \Psr\Container\ContainerInterface $container
     * @var \Framework\App $app
     */

    $container = require_once 'config/container.php';
    $app = $container->get(App::class);

    (require 'config/pipeline.php')($app);

    $app->run();
})();
