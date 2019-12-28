<?php

require 'autoload.php';

$config = new \Chat\Config();
$config->socket_file;

$client = new \Chat\Client($config->socket_file);
$client->run();
