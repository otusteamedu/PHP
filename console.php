<?php

require_once 'vendor/autoload.php';

use App\Application;
use Symfony\Component\Yaml\Yaml;

$config = Yaml::parseFile('config/config.yml');;
$app = new Application($config['main_socket_file'],$config['recipient_socket_file'],$config['exit_command']);
$app->run();