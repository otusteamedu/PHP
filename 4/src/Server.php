<?php


namespace Sockets;
use Exception;

class Server
{

    private $socketFilePath;
    private $messageLength;

    public function __construct(string $socketFilePath, int $messageLength)
    {
        $this->socketFilePath = $socketFilePath;
        $this->messageLength = $messageLength;

        if(file_exists($this->socketFilePath)) {
            unlink($this->socketFilePath);
        }
    }

    public function listen()
    {
        $socket = $this->connect();
        if (!socket_listen($socket)) {
            $this->throwError(socket_strerror(socket_last_error()));
        }

        while (true) {
            $connection = socket_accept($socket);
            while (true) {
                $message = socket_read($connection, $this->messageLength);
                if(empty($message)) {
                    if ($error = socket_last_error($connection)) {
                        $this->throwError($error);
                    }
                } else {
                    echo 'Новое сообщение: ' . $message, PHP_EOL;
                }
            }
        }
    }

    public function __destruct()
    {
        if(file_exists($this->socketFilePath)) {
            unlink($this->socketFilePath);
        }
    }

    private function connect()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if(!socket_bind($socket, $this->socketFilePath)) {
            $this->throwError(socket_strerror(socket_last_error()));
        }

        return $socket;
    }


    private function throwError(string $error)
    {
        throw new Exception('socket error: ' . $error);
    }
}