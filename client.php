#!/usr/local/bin/php
<?php

use App\Socket\SocketClient;

require_once 'vendor/autoload.php';
$config = require 'config.php';

$socketClient = new SocketClient($config['socket'] ?? []);
$socketClient->sendMessage($argv[1] ?? 'Empty message');