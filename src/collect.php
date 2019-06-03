<?php

use Predis\Client;

require '../vendor/autoload.php';

$client = new Client([
    'host' => 'redis'
]);


$client->connect();

$client->disconnect();
