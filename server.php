<?php

/**
 * Сервер.
 *
 * Возвращает перевернутое сообщение клиента
 */

$SERVER_SOCKET = dirname(__FILE__) . '/sockets/server.sock';

// -- Создаем сокет
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
if (false === $socket) {
	die('Не получилось создать UNIX сокет');
}

if (false === socket_bind($socket, $SERVER_SOCKET)) {
	die('Не получилось привязать сокет к файлу');
}
// -- -- -- --

while(true) {
	// -- Ставим блокировку
	if (false === socket_set_block($socket)) {
		die('Не удалось поставить блокировку');
	}
	// -- -- -- --

	// -- Получение данных от клиента
	socket_recvfrom($socket, $message, 65536, 0, $clientAddr);
	echo 'Сообщение от клиента: ' . $message . PHP_EOL;
	// -- -- -- --

	// -- Отправка ответа
	if (false === socket_set_nonblock($socket)) {
		die('Не удалось снять бокировку');
	}

	socket_sendto($socket, strrev($message), strlen($message), 0, $clientAddr);
	// -- -- -- --
}
