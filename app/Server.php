<?php

namespace App;

class Server
{
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function run()
    {
        $socket = $this->createSocketListen($this->config->getServerSocketPath());
        echo 'Для выхода нажмите ctrl+c' . PHP_EOL;
        while (true) {
            $socketConnection = socket_accept($socket);
            echo socket_read($socketConnection, $this->config->getDataLength());
            socket_close($socketConnection);
        }
    }

    private function createSocketListen($filePath) {
        try {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            if (file_exists(self::SERVER_SOCKET_FILE_PATH)) {
                unlink(self::SERVER_SOCKET_FILE_PATH);
            }
            socket_bind($socket, self::SERVER_SOCKET_FILE_PATH);
            socket_listen($socket);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $socket;
    }
}
