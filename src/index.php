<?php

require_once __DIR__ . '/cli.adapter.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.routes.php';

$app = new \App\Core\Bootstrap();
$app->run();