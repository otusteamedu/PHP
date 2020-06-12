<?php

namespace App;

use App\Exceptions\SocketException;

class Client {
    private $pathToSocket;
    private $username;

    public function __construct(string $pathToSocket, string $username) {
        $this->pathToSocket = $pathToSocket;
        $this->username = $username;

    }

    public function createSocket() {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        if (!$socket) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
        $this->getConnect($socket);
        $this->startWrite($socket);

        return $socket;
    }

    private function getConnect($socket) {
        $connect = socket_connect($socket, $this->pathToSocket);
        if (!$connect) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function startWrite($socket) {
        while ($socket) {
            $content = fgetcsv(STDIN);
            socket_write($socket, $this->username . '::' . $content[0]);
        }
    }
}
