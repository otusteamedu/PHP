<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('src/Server.php');

$server = new App\Server('config.ini');
$server->runServer();