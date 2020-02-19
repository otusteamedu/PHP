#!/usr/bin/env php
<?php

use App\Client;
use App\Config;
use App\Socket;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorHandler;

require_once __DIR__ . '/../vendor/autoload.php';

(new ErrorHandler)
    ->pushHandler(new PlainTextHandler)
    ->register();

try {
    $message = $argv[1] ?? Config::get('client_default_message', 'Empty message');
    $socket = (new Socket(AF_UNIX, SOCK_DGRAM))->bind(Config::get('client_socket'));
    $responce = (new Client($socket))->send($message, Config::get('server_socket'));
    echo 'Responce: ' . $responce . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
} finally {
    unset($socket);
}
