<?php
require_once __DIR__ . '/vendor/autoload.php';
use UnixSockets\Server;
$server = new Server();
$server->listen();