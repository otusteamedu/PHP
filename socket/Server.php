<?php

namespace Ozycast\Socket;

class Server extends Socket
{
    private $connect = null;
    public $socket = null;

    public function __construct()
    {
        // В w10 не видит файл, даже если он есть
//        if (is_readable($this->path)) {
            @unlink($this->path);
//        }
    }

    public function start()
    {
        if (!$this->connect())
            return;

        while (true) {
            $this->connect = socket_accept($this->socket);
            if ($this->connect) {
                echo "Client $this->connect has connected", PHP_EOL;
                $this->send($this->connect, "Welcome to Server!");

                while (true) {
                    $this->read($this->connect);
                    if (($error = socket_last_error($this->connect)) == 10054) {
                        echo "Client $this->connect has disconnected", PHP_EOL;
                        break;
                    }
                }
            }
        }

        return;
    }

    public function connect()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!socket_bind($this->socket, $this->path))
            return 0;

        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_listen($this->socket);
        socket_set_nonblock($this->socket);
        return 1;
    }
}