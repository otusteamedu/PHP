<?php
$host = "127.0.0.1";
$port = 5353;
// No Timeout
set_time_limit(0);

// Создаем сокет
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Не могу создать сокет\n");
// Привязываем сокет к хосту и порту
$result = socket_bind($socket, $host, $port) or die("Не могу привязать сокет\n");
// Начинаем слушать порт
while ( true ) {
	$result = socket_listen($socket, 3) or die("Не могу слушать сокет\n");
// Принимаем соединения на сокете
	$client = socket_accept($socket) or die("Не могу принять соединение\n");
// Читаем вход с сокета
	$input = socket_read($client, 1024) or die("Не могу читать что мне там прислали\n");
// Отправляем обратно
	socket_write($client, 'From server ' . $input, 1024) or die("Не могу передать данные\n");

// Закрываем сокеты
	socket_close($client);
}