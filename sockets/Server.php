<?php

class Server
{
    private $socket;

    public function __construct($domain, $type, $protocol)
    {
        $this->socket = socket_create($domain, $type, $protocol);
        if ($this->socket === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }
    }

    public function initServerSocket($domainSocket)
    {
        $address = dirname(__FILE__) . $domainSocket;

        if (socket_bind($this->socket, $address) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }
        if (socket_listen($this->socket, 5) === false) {
            echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }
    }

    public function processedMsgFromClient()
    {
        while (true) {
            $msgSocket = socket_accept($this->socket);
            if ($msgSocket === false) {
                echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
                break;
            }
            $msgFromClient = socket_read($msgSocket, 1024);
            if ($msgFromClient === false) {
                echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
                break;
            }
            $output = "Got your message: " . $msgFromClient . "\n";
            socket_write($msgSocket, $output);
        }
    }

    public function closeSocket()
    {
        socket_close($this->socket);
    }
}