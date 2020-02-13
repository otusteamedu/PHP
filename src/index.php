<?php

require_once __DIR__ . '/cli.adapter.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.routes.php';

$env = new \App\Core\Environment();
$app = new \App\Core\Bootstrap($env);
$app->run();