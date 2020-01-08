<?php

set_time_limit(0);

ob_implicit_flush();

$serverSocket = 'php_server.sock';

if (file_exists($serverSocket)) {
    unlink($serverSocket); //delete before first run
}

$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

if ($socket === false) {
    die('Unable to create server socket. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
}

if (socket_bind($socket, $serverSocket) === false) {
    die('Unable to bind server socket. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
}

if (socket_listen($socket, 5) === false) {
    die('Unable to listen server socket. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
}


do {
    echo "Ждём клиентов \n";
    $socketHandler = socket_accept($socket);
    echo "Подключился кто-то \n";
    if ($socketHandler === false) {
        die('Unable to socket_accept. Reason: '.socket_strerror(socket_last_error()).PHP_EOL);
    }

    $greeting = 'Server: Жду от вас сообщения!'.PHP_EOL;
    echo $greeting;
    socket_write($socketHandler, $greeting, strlen($greeting));

    while (true) {
        $msg = socket_read($socketHandler, 1000000, PHP_NORMAL_READ);
        if ($msg === false) {
            echo "Соединение с клиентом завершено.\n";
            break;
            // die('Cannot to execute socket_read. Reason: '.socket_strerror(socket_last_error()));
        }
        if ($msg === '') {
            continue;
        }
        $msg = trim($msg);

        $answer = "Server: Вы прислали '{$msg}'".PHP_EOL;
        socket_write($socketHandler, $answer, strlen($answer));
        echo 'Сообщение от клиента '.$msg.PHP_EOL;
    }

    socket_close($socketHandler);
} while (true);

socket_close($socket);