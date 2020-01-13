<?php


namespace Ushakov;

use \Exception;


class Client
{
    /**
     * @var resource
     */
    protected $socket;


    /**
     * @param string $socketFileName
     *
     * @throws Exception
     */
    public function __construct(string $socketFileName)
    {
        $this->createSocket($socketFileName);
    }

    /**
     * @param string $socketFileName
     *
     * @throws Exception
     */
    protected function createSocket(string $socketFileName)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new Exception("Can't create socket");
        }
        if (socket_connect($this->socket, $socketFileName) === false) {
            throw new Exception("Can't connect to socket file");
        }
    }

    /**
     * @param string $message
     *
     * @throws Exception
     */
    public function sendMessage(string $message): void
    {
        if (socket_write($this->socket, $message . PHP_EOL) === false) {
            throw new Exception("Cant send message");
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function receiveMessage(): string
    {
        if (($serverMessage = socket_read($this->socket, 2048, PHP_NORMAL_READ)) === false) {
            throw new Exception("Can't receive message");
        }
        return $serverMessage;
    }

    public function closeConnection()
    {
        socket_write($this->socket, Server::QUIT_MESSAGE);
        socket_close($this->socket);
    }

}
