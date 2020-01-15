<?php
use UnixSockets\Client;

require_once __DIR__ . '/../vendor/autoload.php';

new Client(false, $argv[1]);
