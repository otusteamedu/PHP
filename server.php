#!/usr/local/bin/php
<?php

use App\Socket\SocketServer;

require_once 'vendor/autoload.php';

$config = require 'config.php';

$serverSocket = new SocketServer($config['socket'] ?? []);
$serverSocket->serve();

echo 'Hello!'.PHP_EOL;