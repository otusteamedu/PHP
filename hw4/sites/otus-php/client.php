<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('src/Client.php');

$server = new App\Client('config.ini');
$server->runClient();

