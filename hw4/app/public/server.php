<?php

require 'autoload.php';

$config = new \Chat\Config();
$config->socket_file;

$server = new \Chat\Server($config->socket_file);
$server->run();
