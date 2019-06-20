<?php

use Otus\Config;

require_once 'config.php';
require_once 'bootstrap.php';

try {
    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    $serverSocketFile = Config::getServerSocket();

    pcntl_signal(SIGTERM, function ($signo) use ($socket, $serverSocketFile) {
        socket_close($socket);
        unlinkIfExist($serverSocketFile);
        exit;
    });

    unlinkIfExist($serverSocketFile);
    socket_bind($socket, $serverSocketFile);

    while (true) {
        socket_set_block($socket);

        $buffer = $from = null;

        socket_recvfrom($socket, $buffer, 2 ** 16, 0, $from);
        socket_set_nonblock($socket);

        $response = '-------------------' . PHP_EOL;
        $response .= 'Received: ' . PHP_EOL . 'Message: ' . $buffer . PHP_EOL . 'From: ' . $from . PHP_EOL;
        $response .= '-------------------' . PHP_EOL;

        socket_sendto($socket, $response, strlen($response), 0, $from);

        if ($buffer === 'kill') {
            posix_kill(posix_getpid(), SIGTERM);
        }
    }
} catch (ErrorException $e) {
    echo $e->getMessage() . PHP_EOL;
    posix_kill(posix_getpid(), SIGTERM);
}

