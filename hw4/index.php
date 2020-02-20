<?php

require_once "vendor/autoload.php";

$app = \Chat\Application::create();
if ($app)
    $app->run();