<?php

require_once __DIR__ . '/cli.adapter.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.routes.php';

$env = new \Core\Environment();
$app = new \Core\Bootstrap($env);

$app->run();