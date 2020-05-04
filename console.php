<?php

require_once 'vendor/autoload.php';

use App\Application;
use Symfony\Component\Yaml\Yaml;

$config = Yaml::parseFile('config/config.yml');;
$app = new Application();
$app->run();