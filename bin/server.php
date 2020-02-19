#!/usr/bin/env php
<?php

use App\Config;
use App\Server;
use App\Socket;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorHandler;

require_once __DIR__ . '/../vendor/autoload.php';

(new ErrorHandler)
    ->pushHandler(new PlainTextHandler)
    ->register();

try {
    $socket = (new Socket(AF_UNIX, SOCK_DGRAM))->bind(Config::get('server_socket'));
    (new Server($socket))->run();
} catch (Throwable $e) {
    throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
} finally {
    unset($socket);
}
