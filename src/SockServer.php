<?php

class SockServer
{
    protected $socket;

    // Конструктор
    public function __construct()
    {
        $file = "myserver.sock";
        @unlink($file);
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (socket_bind($socket, $file) === false) {
            echo "Не удалось задать адресс сокету" . PHP_EOL;
            die();
        }
        
        $result = socket_listen($socket);
        if (!$result) {
            echo "Не удалось подключиться к сокету" . PHP_EOL;
            die();
        }

        $this->socket = $socket;
    }

    // Главный цикл
    public function Run()
    {   

        echo "Ожидание сообщений (Для выхода нажмите CTRL+C)..." . PHP_EOL;
        while (true) {
            $connection = socket_accept($this->socket);
            if (!$connection) {
                echo "Не удалось подключиться к сокету" . PHP_EOL;
                die();
            }
            $input = socket_read($connection, 1024);
            $client = $input;
            echo $client . PHP_EOL;
            socket_close($connection);
        }
    }

}