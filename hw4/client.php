<?php
use UnixSockets\Client;
require_once __DIR__ . '/vendor/autoload.php';

const SOCKET_FILE = __DIR__ .'/unix.sock';
$client = new Client(SOCKET_FILE);
$client->connect();