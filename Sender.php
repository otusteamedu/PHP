<?php
require_once __DIR__ . '/vendor/autoload.php';
use Client\Client;
$client = new Client('config.ini');
$client->run();