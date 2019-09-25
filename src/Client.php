<?php

namespace UnixSockets;

class Client
{

    /**
     * @var resource
     */
    private $socket;
    /**
     * @var string
     */
    private $socketFilePath;

    /**
     * Client constructor.
     * @param string $socketFilePath
     * @throws \Exception
     */
    public function __construct(string $socketFilePath)
    {
        $this->socketFilePath = $socketFilePath;
    }

    /**
     * @throws \Exception
     */
    public function connect()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_set_nonblock($this->socket);
        if(!socket_connect($this->socket, $this->socketFilePath)) {
            throw new \Exception(socket_strerror(socket_last_error()));
        }

        return $this;
    }

    /**
     * @param string $message
     * @throws \Exception
     */
    public function ping(string $message)
    {
        socket_write($this->socket, $message);
        if ($error = socket_last_error()) {
            throw new \Exception($error);
        }
    }
}