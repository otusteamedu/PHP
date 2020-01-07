<?php


namespace Ushakov;

use \Exception;


class Server
{
    /**
     * @var resource
     */
    protected $socket;

    /**
     * @var resource
     */
    protected $clientSocket;

    const QUIT_MESSAGE = "q" . PHP_EOL;

    /**
     * @param string $socketFileName
     *
     * @throws Exception
     */
    public function __construct(string $socketFileName)
    {
        $this->clearSocketFile($socketFileName);
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
        if (socket_bind($this->socket, $socketFileName) === false) {
            throw new Exception("Can't bind to socket file");
        }
        if (socket_listen($this->socket, 1) === false) {
            throw new Exception("Can't listen to socket");
        }
    }

    public function clearSocketFile(string $socketFileName)
    {
        if (file_exists($socketFileName)) {
            unlink($socketFileName);
        }
    }

    /**
     * @throws Exception
     */
    public function waitForClient()
    {
        if (($this->clientSocket = socket_accept($this->socket)) === false) {
            throw new Exception("Error waiting for client connection");
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function receiveMessage(): string
    {
        if (($message = socket_read($this->clientSocket, 2048, PHP_NORMAL_READ)) === false) {
            throw new Exception("Can't receive message");
        }
        return $message;
    }

    /**
     * @param string $message
     *
     * @throws Exception
     */
    public function sendMessage(string $message): void
    {
        if (socket_write($this->clientSocket, $message . PHP_EOL) === false) {
            throw new Exception("Cant send message");
        }
    }

    public function closeConnection()
    {
        socket_close($this->clientSocket);
        socket_close($this->socket);
    }
}
