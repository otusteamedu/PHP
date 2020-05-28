<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new \HW4\Client(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));
$client->sendRequest();
echo 'Ответ: ' . $client->getResponse() . PHP_EOL;