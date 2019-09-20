<?php
$host = "127.0.0.1";
$port = 5353;
// No Timeout
set_time_limit(0);

// Готовим параметры из командной строки для передачи на сервер
$opts = "";
$opts .= "f:";  // Required
$opts .= "s:";  // Required

$options = getopt( $opts );
$message = implode(' :: ', $options);

//Организуем сокет для передачи данных аналогично серверу
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Не могу создать сокет\n");
$result = socket_connect($socket, $host, $port) or die("Сервер отвалился\n");

// шлем нашу строку
socket_write($socket, $message, strlen($message)) or die("Не могу послать данные\n");
// получаем ответ от сервера
$result = socket_read ($socket, 1024) or die("Не могу читать ответ\n");
echo $result . PHP_EOL;

// закрываем сокет
socket_close($socket);