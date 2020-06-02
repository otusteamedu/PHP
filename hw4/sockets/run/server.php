<?php

use UxSockets\Server;

require_once __DIR__ . '/../vendor/autoload.php';

$server = new Server();
$server->runServer();
