<?php


namespace App;


class Client
{
    private string $socketFile;


    function __construct($socketFile)
    {
        $this->socketFile = $socketFile;
    }


    public function runDaemon(): void
    {
        while (true) {
            $message = trim(readline("Введите ваше имя или stop для остановки сервера: "));
            echo $this->sendMessage($message);
            if ($message == "stop") {
                break;
            }
        }
    }


    private function sendMessage(string $msg): string
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($socket, $this->socketFile);
        socket_write($socket, $msg);
        $response = socket_read($socket, 2048);
        socket_close($socket);
        return $response;
    }
}