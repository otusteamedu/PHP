<?php 

namespace Application;

class Client
{

    private $socket;
    private $socket_dir;

    public function __construct() 
    {
        $this->socket_dir = "../".$_ENV['SOCKET_DIR']."/";

    }

    public function run()
    {
        $this->createSocket();
        $this->connectSocket();
        $this->createCommunication();
    }

    private function createSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    private function connectSocket()
    {
        socket_connect($this->socket, $this->socket_dir.$_ENV['SOCKET_FILE'], $_ENV['PORT']);
    }

    private function getClientMessage()
    {
        return trim(fgets(STDIN));
    }

    private function sendClientMessage($client_message)
    {
        socket_write($this->socket, $client_message, strlen($client_message));
    }

    private function getServerResponse()
    {
        return socket_read($this->socket, 1024);
    }

    private function createCommunication()
    {
        echo "Введите сообщение для сервера \n";
        $client_message = $this->getClientMessage();
        $this->sendClientMessage($client_message);
        echo "Ожидаем ответ от сервера \n";
        echo "Сервер ответил ".$this->getServerResponse()." \n";


    }
}