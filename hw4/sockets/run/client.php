<?php

use UxSockets\Client;

require_once __DIR__ . '/../vendor/autoload.php';

$client = new Client();
$client->runClient();
