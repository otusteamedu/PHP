<?php

$socket_server_reads_file = 'server';
$socket_client_reads_file = 'client';

// Подлючение к сокету
$socket_server_reads = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_bind($socket_server_reads, $socket_server_reads_file);

// Общение
echo "Let's start!" . PHP_EOL . PHP_EOL;
while(1) {
    echo "Look through the socket..." . PHP_EOL;
    // Получение сообщения
    socket_recvfrom($socket_server_reads, $message_received, 32, 0, $socket_server_reads_file);
    echo "A message was received. Text:" . PHP_EOL;
    echo $message_received . PHP_EOL;

    // Отправка "pong"
    $socket_client_reads = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    socket_connect($socket_client_reads, $socket_client_reads_file);    
    $message_sent = '>"' . $message_received . '"< was received' . PHP_EOL;
    socket_sendto($socket_client_reads, $message_sent, 32, 0, $socket_client_reads_file);
    echo "Pong was sent" . PHP_EOL;
}