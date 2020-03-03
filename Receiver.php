<?php
require_once __DIR__ . '/vendor/autoload.php';
use Server\Server;
$server = new Server('config.ini');
$socket = $server->connect();
$server->run($socket);
