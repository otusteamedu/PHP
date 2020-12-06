<?php

namespace app;

trait SocketConnectionTrait
{
    public $socket = null;

    public function createConnection()
    {
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        } catch (\Throwable $e) {
            echo 'Could not create socket: ' . $e->getMessage() . PHP_EOL;
        }
    }

    public function bindSocket()
    {
        echo 'Binding socket ' . PHP_EOL;

        if (file_exists(getenv('SOCKET_FILE'))) {
            unlink(getenv('SOCKET_FILE'));
        }

        if (!socket_bind($this->socket, getenv('SOCKET_FILE'))) {
            throw new \Exception('Unable to bind to' . getenv('SOCKET_FILE'));
        }
    }
}