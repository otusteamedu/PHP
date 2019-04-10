#!/usr/bin/php -q
<?php

require '../vendor/autoload.php';
use nvggit\Client;

set_time_limit(0);
ob_implicit_flush();


$client = new Client();
$client->start();

