<?php

namespace App;

use App\Exceptions\SocketException;

class Server {

    private $pathToSocket;

    public function __construct(string $pathToSocket) {
        $this->pathToSocket = $pathToSocket;
    }

    public function createSocket() {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        if (!$socket) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
        $this->bindSocket($socket);
        $this->listenSocket($socket);
        $connect = $this->getConnect($socket);
        $this->startListen($connect);
    }

    private function bindSocket($socket): void {
        if (file_exists($this->pathToSocket)) {
            unlink($this->pathToSocket);
        }
        $bind = socket_bind($socket, $this->pathToSocket);
        if (!$bind) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
    }

    private function listenSocket($socket): void {
        $listen = socket_listen($socket, 10);
        if (!$listen) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
    }

    private function getConnect($socket) {
        $connect = socket_accept($socket);
        if (!$connect) {
            throw new SocketException(socket_strerror(socket_last_error()));
        }
        return $connect;
    }

    private function startListen($connect) {
        while (true) {
            $result = socket_read($connect, 80000);
            echo $result . "\r\n";
        }
    }
}
