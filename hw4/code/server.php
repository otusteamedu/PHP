<?php
declare(strict_types=1);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

if (!$socket) {
    exit(socket_strerror(socket_last_error()));
}
echo 'Сокет создан!' . PHP_EOL;

$serverSideSocket = dirname(__FILE__)."/server.sock";

if (!socket_bind($socket, $serverSideSocket)) {
    exit(socket_strerror(socket_last_error()));
}
echo 'Сокет привязан!' . PHP_EOL;

while (true) {
    if (!socket_set_block($socket)) {
        exit('Не удалось установить блокировку' . PHP_EOL);
    }
    echo 'Блокировка установлена, ожидаю соединения' . PHP_EOL;
    $request = '';
    $fileName = '';
    $bytesReceived = socket_recvfrom($socket, $request, 65536, 0, $fileName);
    if ($bytesReceived === false) {
        exit(socket_strerror(socket_last_error()));
    }
    echo "Получено $request из $fileName" . PHP_EOL;

    $response = "Вот какой запрос получил сервер: $request";

    if (!socket_set_nonblock($socket)) {
        exit('Не удалось снять блокировку' . PHP_EOL);
    }

    $length = strlen($response);
    $bytesSent = socket_sendto($socket, $response, $length, 0, $fileName);
    if ($bytesSent === false) {
        exit(socket_strerror(socket_last_error()));
    } else if ($bytesSent != $length) {
            exit("Было отправлено $bytesSent вместо $length" . PHP_EOL);
        }
}
