<?php

use Framework\App;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require_once 'config/container.php';

    $app = new App();

    (require 'config/pipeline.php')($app, $container);

    $app->run();
})();
