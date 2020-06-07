<?php
require_once __DIR__.'/../vendor/autoload.php';

use App\Application;
use App\Request;

$request = new Request($_GET, $_POST);
$app = new Application($request);
$app->run();