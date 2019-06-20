<?php

use Otus\Config;

require_once 'config.php';
require_once 'bootstrap.php';

try {
    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    $id = uniqid();
    $clientSocketFile = Config::getClientSocket($id);
    $serverSocketFile = Config::getServerSocket();

    pcntl_signal(SIGTERM, function ($signo) use ($clientSocketFile) {
        unlinkIfExist($clientSocketFile);
        echo 'Bye' . PHP_EOL;
        exit;
    });



    unlinkIfExist($clientSocketFile);

    socket_connect($socket, $serverSocketFile);
    socket_bind($socket, $clientSocketFile);
    socket_set_nonblock($socket);

    while ($message = trim(fgets(STDIN))) {
        socket_sendto($socket, $message, strlen($message), 0, $serverSocketFile);
        socket_set_block($socket);
        $buffer = $from = null;
        socket_recvfrom($socket, $buffer, 2 ** 16, 0, $from);
        echo $buffer;

        if (in_array($message, ['quit', 'kill'])) {
            break 1;
        }
    }

    socket_close($socket);
    unlinkIfExist($clientSocketFile);
    posix_kill(posix_getpid(), SIGTERM);
} catch (ErrorException $e) {
    echo $e->getMessage() . PHP_EOL;
    unlinkIfExist($clientSocketFile);
    posix_kill(posix_getpid(), SIGTERM);
}