<?php

namespace Ozycast\Socket;

class Client extends Socket
{
    private $connect = null;

    public function start()
    {
        if (!$this->connect())
           return;

        $this->send($this->connect, "Hello");

        while (true) {
            $this->read($this->connect);
            if (($error = socket_last_error($this->connect)) == $this::ERROR_CODE_DISCONNECT) {
                echo "Server $this->connect has disconnected", PHP_EOL;
                break;
            }
        }
        return;
    }

    public function connect()
    {
        $this->connect = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!socket_connect($this->connect, $this->path)) {
            echo "Error connection!";
            return 0;
        }

        return 1;
    }
}