<?php

use Core\App;
use Core\AppConfig;

require_once __DIR__ . "/vendor/autoload.php";

App::setRoutes(__DIR__ . "/app/data/routes.json");
App::setViewsPath(__DIR__ . "/app/views/");

$app = new App(new AppConfig(__DIR__ . "/app/data/app.conf.ini"));
$app->run();