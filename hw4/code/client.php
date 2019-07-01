<?php
declare(strict_types=1);

if ($argc == 1) {
    exit("Не введено сообщение" . PHP_EOL);
}
$message = $argv;
unset($message[0]);
$message = implode(' ', $message);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (!$socket) {
    exit(socket_strerror(socket_last_error()));
}

$clientSideSocket = dirname(__FILE__)."/client.sock";
if (!socket_bind($socket, $clientSideSocket)) {
    exit(socket_strerror(socket_last_error()));
}

if (!socket_set_nonblock($socket)) {
    exit('Не удалось снять блокировку' . PHP_EOL);
}

$serverSideSocket = dirname(__FILE__)."/server.sock";
$length = strlen($message);

$bytesSent = socket_sendto($socket, $message, $length, 0, $serverSideSocket);
if ($bytesSent === false) {
    exit(socket_strerror(socket_last_error()));
} else if ($bytesSent != $length) {
    exit("Было отправлено $bytesSent вместо $length" . PHP_EOL);
}


if (!socket_set_block($socket)) {
    exit('Не удалось установить блокировку' . PHP_EOL);
}
$response = '';
$fileName = '';
$bytesReceived = socket_recvfrom($socket, $response, 65536, 0, $fileName);
if ($bytesReceived === false) {
    exit(socket_strerror(socket_last_error()));
}
echo "Получен ответ от сервера: $response из $fileName" . PHP_EOL;

socket_close($socket);
unlink($clientSideSocket);
echo "Работа клиента завершена" . PHP_EOL;
