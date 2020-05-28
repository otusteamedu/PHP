<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$server = new \HW4\Server(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));
$server->up();