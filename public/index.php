<?php

use Framework\App;
use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

// todo: add envs prod dev test
// todo: db for tests
// todo: all commands in one console

(function () {
    if (file_exists('.env')) {
        (new Dotenv(true))->load('.env');
    }

    /**
     * @var \Psr\Container\ContainerInterface $container
     * @var \Framework\App $app
     */

    $container = require_once 'config/container.php';
    $app = $container->get(App::class);

    (require 'config/pipeline.php')($app);

    $app->run();
})();
