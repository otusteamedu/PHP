<?php
require "vendor/autoload.php";

use Ushakov\App;

set_time_limit(0);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new \Ushakov\App();
$app->run();
