<?php

namespace models;

class SocketClient extends Socket
{
    /**
     * Initialisation for client
     *
     * @throws \Exception
     */
    protected function init()
    {
        if (!socket_connect($this->sock, $this->host))
            throw new \Exception("Client: can`t connect to server socket \n");
    }

    /**
     * Run client script
     *
     * @throws \Exception
     */
    public function run()
    {
        $msg = "Hello I`m client from " . __CLASS__ . "\n";

        if (socket_write($this->sock, $msg, strlen($msg)) === false)
            throw new \Exception("Client: can`t write to socket \n");

        if (($result = socket_read($this->sock, self::SOCKET_READ_LENGTH)) !== false)
            echo "Reply from server socket: $result \n";
        else
            throw new \Exception("Cant read response from server \n");
    }


}