<?php

use Core\App;
use Core\AppConfig;
use Core\AppRouter;

require_once __DIR__ . "/vendor/autoload.php";

AppRouter::setRoutesFromFile(__DIR__ . "/app/data/routes.json");
AppRouter::setViewsPath(__DIR__ . "/app/views/");

$app = new App();
$app->run(new AppConfig(getenv()));