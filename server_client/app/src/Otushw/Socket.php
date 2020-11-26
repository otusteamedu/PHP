<?php

namespace Otushw;

use Exception;

class Socket
{
    protected $socket;
    protected $pathSocket;
    protected $portSocket;

    public function __construct()
    {
        $config = new Config();
        $this->pathSocket = $config->readParam('SOCKET_PATH');
        $this->portSocket = $config->readParam('SOCKET_PORT');

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket == false) {
            throw new Exception("Can't create socket");
        }
    }

    public function __destruct()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }

    public function initServer()
    {
        if (file_exists($this->pathSocket)) {
            unlink($this->pathSocket);
        }

        if (!socket_bind($this->socket, $this->pathSocket, $this->portSocket)) {
            throw new Exception("Can't bind socket");
        }

        if (!socket_listen($this->socket, 0)) {
            return new Exception("Can't connect socket");
        }
    }

    public function socketAccept()
    {
        $socketAccept = socket_accept($this->socket);
        if (empty($socketAccept)) {
            throw new Exception("Can't accept socket");
        }
        return $socketAccept;
    }

    public function socketRead($socketAccept)
    {
        $buf = socket_read($socketAccept, 1024);
        if ($buf === false) {
            throw new Exception("Can't read socket");
        }
        return $buf;
    }

    public function readSTDIN()
    {
        return trim(fgets(STDIN));
    }

    public function socketWrite($socket, $message)
    {
        $result = socket_write(
            $socket,
            $message,
            strlen($message)
        );
        if ($result === false) {
            throw new Exception("Can't write in socket");
        }
    }

    public function initClient()
    {
        if (!socket_connect($this->socket, $this->pathSocket, $this->portSocket)) {
            return new Exception("Can't connect socket");
        }
    }

    public function getSocket()
    {
        return $this->socket;
    }

}