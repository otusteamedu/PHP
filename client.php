<?php

ob_implicit_flush();

$address = 'localhost';
$port = 1965;

if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "Ошибка создания сокета";
} else {
    echo "Сокет создан\n";
}

$connect = socket_connect($socket, $address, $port);
if ($connect === false) {
    echo "Ошибка при подключении к сокету";
} else {
    echo "Подключение к сокету прошло успешно\n";
}

$output = socket_read($socket, 1024);
echo "Сообщение от сервера: $output\n";

$message = "15";
echo "Сообщение серверу: $message\n";
socket_write($socket, $message, strlen($message));

$output = socket_read($socket, 1024);
echo "Сообщение от сервера: $output\n";

$message = 'exit';
echo "Сообщение серверу: $message\n";
socket_write($socket, $message, strlen($message));
echo "Соединение завершено\n";

if (isset($socket)) {
    socket_close($socket);
    echo "Сокет успешно закрыт\n";
}
