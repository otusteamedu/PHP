<?php

namespace App;

class Client
{
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function run()
    {
        echo 'Введите имя пользователя:';
        $clientName = trim(fgets(STDIN));
        echo 'Для вызода нажмите q' . PHP_EOL;
        while (true) {
            echo 'Введите сообщение:' . PHP_EOL;
            $message = fgets(STDIN);
            if ($message == 'q' || $message == 'q' . PHP_EOL) {
                exit;
            }
            $result = $this->socketWrite($this->config->getServerSocketPath(), $clientName . ': ' . $message);
            if (!$result) {
                echo 'Сообщение не отправленно';
                exit;
            }
        }

    }

    private function socketWrite($filePath, $message)
    {
        try {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            socket_connect($socket, $filePath);
            socket_write($socket, $message);
            socket_close($socket);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}