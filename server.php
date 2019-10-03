<?php
ob_implicit_flush();
$address = 'localhost';
$port = 1965;
if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "Ошибка создания сокета";
} else {
    echo "Сокет создан\n";
}

if (($result = socket_bind($socket, $address, $port)) < 0) {
    echo "Ошибка связи сокета с адресом и портом";
} else {
    echo "Сокет успешно связан с адресом и портом\n";
}

if (($result = socket_listen($socket, 5)) < 0) {
    echo "Ошибка при попытке прослушивания сокета";
} else {
    echo "Ждём подключение клиента\n";
}

do {
    if (($connection = socket_accept($socket)) < 0) {
        echo "Ошибка при старте соединений с сокетом";
    } else {
        echo "Сокет готов к приёму сообщений\n";
    }
    $message = "Hello!";
    echo "Сообщение от сервера: $message\n";
    socket_write($connection, $message, strlen($message));

    do {
        echo 'Сообщение от клиента: ';
        if (false === ($buf = socket_read($connection, 1024))) {
            echo "Ошибка при чтении сообщения от клиента";
        } else {
            echo $buf . "\n";
        }

        if ($buf == 'exit') {
            socket_close($connection);
            break 2;
        }
        if (!is_numeric($buf)) {
            echo "Сообщение от сервера: передано НЕ число\n";
        } else {
            $buf = $buf * $buf;
            echo "Сообщение от сервера: $buf\n";
        }

        socket_write($connection, $buf, strlen($buf));

    } while (true);
} while (true);

if (isset($socket)) {
    socket_close($socket);
    echo "Сокет успешно закрыт\n";
}
