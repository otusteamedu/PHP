<?php
use UnixSockets\Client;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require_once __DIR__ . '/config.php';

new Client($config, false, $argv[1]);
