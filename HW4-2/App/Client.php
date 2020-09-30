<?php


namespace App;


use Socket\Socket;

class Client
{
    private Socket $socket;

    public function __construct()
    {
        $this->initSocket();
        $this->writeClient();
    }

    private function initSocket()
    {
        $this->socket = new Socket($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
        $this->socket->create();
        $this->socket->connect();
    }

    private function writeClient()
    {
        while (true) {

            $message = $this->writeStd();

            $this->socket->write($message);

            if ($message === 'quit') {
                echo 'Exiting...' . PHP_EOL;
                break;
            }
        }

        $this->socket->close();
    }

    private function writeStd()
    {
        echo "Введите сообщение: " . PHP_EOL;
        return rtrim(fgets(STDIN));
    }
}