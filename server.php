#!/usr/bin/env php
<?php

use APankov\SocketServer as Server;

require_once "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load(); //загружаем конфигурации

$exit_command = getenv('SOCKET_DISCONNECT_COMMAND');
$server = new Server(getenv('SOCKET_HOST'), getenv('SOCKET_PORT'));

$server->sendMsg('Как тебя зовут?');
$name = $server->readMsg();

$server->sendMsg('Привет, ' . $name . '!');
$wish = $server->readMsg();

while (strtolower($wish) != $exit_command) {
    $server->sendMsg('Набери \'' . $exit_command . '\' для того чтобы отсоединиться');
    $wish = $server->readMsg();
}

$server->sendMsg(getenv('SOCKET_DISCONNECT_COMMAND_CLIENT'));