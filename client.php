<?php
use UnixSockets\Client;
require_once __DIR__ . '/vendor/autoload.php';
$client = new Client();
$client->connect();