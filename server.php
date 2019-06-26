<?php

/**
 * Сервер.
 *
 * Возвращает перевернутое сообщение клиента
 */
$HOST = "127.0.0.1";
$PORT = 25005;

// -- Создаем сокет
$socket = stream_socket_server("tcp://$HOST:$PORT", $errno, $errstr);

if (false === $socket) {
	die("$errstr ($errno)" . PHP_EOL);
}
// -- -- -- --

// -- Обрабатываем входящие соединения
while ($connect = stream_socket_accept($socket, -1)) {
	$input = fread($connect, 1024);
	echo 'Сообщение от клиента: ' . trim($input) . PHP_EOL;

	fputs($connect, strrev($input)); // Переворачиваем строку и возвращаем клиенту

	fclose($connect);
}
// -- -- -- --

fclose($socket);
