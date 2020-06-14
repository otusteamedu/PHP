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
            throw new \Exception("Client: can`t connect to server socket".PHP_EOL);
    }

    /**
     * Run client script
     *
     * @throws \Exception
     */
    public function run()
    {
        $msg = "Hello I`m client from " . __CLASS__ . PHP_EOL;

        if (socket_write($this->sock, $msg, strlen($msg)) === false)
            throw new \Exception("Client: can`t write to socket". PHP_EOL);

        if (($result = socket_read($this->sock, $this->read_length)) !== false)
            echo "Reply from server socket: $result". PHP_EOL;
        else
            throw new \Exception("Cant read response from server". PHP_EOL);
    }


}