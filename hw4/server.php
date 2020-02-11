<?php
require_once __DIR__ . '/vendor/autoload.php';
use UnixSockets\Server;

const SOCKET_FILE = __DIR__ .'/unix.sock';

$server = new Server(SOCKET_FILE);
$server->listen();