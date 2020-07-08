<?php

use Application\Application;
use Symfony\Component\HttpFoundation\Request;

require_once(__DIR__ . '/../vendor/autoload.php');

$app = new Application();
$request = Request::createFromGlobals();
$response = $app->run($request);
$response->send();
