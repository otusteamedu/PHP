<?php

$socket_server_reads_file = 'server';
$socket_client_reads_file = 'client';

// Подлючение к сокету
$socket_server_reads = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_connect($socket_server_reads, $socket_server_reads_file);

$socket_client_reads = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_bind($socket_client_reads, $socket_client_reads_file);    

// Общение
echo "Let's start!" . PHP_EOL . PHP_EOL;
while(1) {
    // Чтение ввода
    echo "Enter your message:" . PHP_EOL;
    $message_sent = fgets(STDIN);

    // Отправка
    socket_sendto($socket_server_reads, $message_sent, 32, 0, $socket_server_reads_file);
    echo "Message sent" . PHP_EOL;

    // Получение "pong"
    socket_recvfrom($socket_client_reads, $message_received, 32, 0, $socket_client_reads_file);
    echo "A message was received. Text:" . PHP_EOL;
    echo $message_received . PHP_EOL;
}