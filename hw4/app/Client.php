<?php

class Client
{
    private $socket;
    private $config;

    public function __construct()
    {
        $this->getConfig();
        $this->connect();
    }

    private function getConfig(): void
    {
        $this->config = require_once __DIR__ . "/config.php";
    }

    private function getName(): string
    {
        return readline("Введите ваше имя или stop для остановки сервера: ");
    }


    private function connect(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->config["file"]);
    }


    public function sendMessage(): string
    {
        $username = $this->getName();
        socket_write($this->socket, $username, strlen($username));
        return socket_read($this->socket, 2048);
    }


    public function __destruct()
    {
        socket_close($this->socket);
    }

}

$client = new Client();
echo $client->sendMessage();
