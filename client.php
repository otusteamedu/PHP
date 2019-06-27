<?php

/**
 * Клиент.
 *
 * Сообщением является 1-ый аргумент, переданный через консоль.
 */

if ($argc == 1) {
	die('Введите сообщение' . PHP_EOL);
}

$message       = $argv[1];
$CLIENT_SOCKET = dirname(__FILE__) . '/sockets/client.sock';
$SERVER_SOCKET = dirname(__FILE__) . '/sockets/server.sock';

// -- Создаем сокет
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (false === $socket) {
	die('Не получилось создать UNIX сокет');
}
// -- -- -- --

if (false === socket_bind($socket, $CLIENT_SOCKET)) {
	die('Не получилось привязать сокет к файлу');
}

// -- Устанавливаем неблокирующий режим
if (false === socket_set_nonblock($socket)) {
	die('Не удалось установить небокирующий режим');
}
// -- -- -- --

$bytes_sent = socket_sendto($socket, $message, strlen($message), 0, $SERVER_SOCKET); // Отправка сообщения

// Получение данных от сервера
if (false === socket_set_block($socket)) {
	die('Не удалось поставить блокировку');
}

socket_recvfrom($socket, $serverMessage, 65536, 0, $from);

echo 'Сообщение от сервера: ' . $serverMessage . PHP_EOL;
// -- -- -- --

// Закрываем сокет и удаляем привязанный к нему файл
socket_close($socket);
unlink($CLIENT_SOCKET);
