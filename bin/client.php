#!/usr/bin/env php
<?php

use App\Client;
use App\Socket;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorHandler;

require_once __DIR__ . '/../vendor/autoload.php';

(new ErrorHandler)
    ->pushHandler(new PlainTextHandler)
    ->register();

$message = $argv[1] ?? (parse_ini_file(__DIR__ . '/../app.ini')['client_default_message'] ?? 'Empty message');
try {
    $socket = (new Socket(AF_UNIX, SOCK_DGRAM))->bind(getenv('SOCKET_CLIENT'));
    $responce = (new Client($socket))->send($message, getenv('SOCKET_SERVER'));
    echo 'Responce: ' . $responce . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
} finally {
    unset($socket);
}
