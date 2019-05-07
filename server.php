#!/usr/bin/php -q
<?php

require './vendor/autoload.php';
use nvggit\Server;

set_time_limit(0);
ob_implicit_flush();

$server = new Server();
$server->start();