<?php

/**
 * Клиент.
 *
 * Сообщением является 1-ый аргумент, переданный через консоль.
 */
if ($argc == 1) {
	die('Введите сообщение' . PHP_EOL);
}

$HOST    = "127.0.0.1";
$PORT    = 25005;
$MESSAGE = $argv[1];

// -- Получение соединения с сокетом
$socket = stream_socket_client("tcp://$HOST:$PORT", $errno, $errstr);
if (false === $socket) {
	die("$errstr ($errno)" . PHP_EOL);
}
// -- -- -- --

// -- Отправка сообщения и получения ответа сервера
fputs($socket, $MESSAGE);
echo 'Сообщение от сервера: ' . fread($socket, 1024) . PHP_EOL;
// -- -- -- --

fclose($socket);
