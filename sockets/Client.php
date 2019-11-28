<?php

class Client
{
    private $socket;
    
    public function __construct($domain, $type, $protocol)
    {
        $this->socket = socket_create($domain, $type, $protocol);
        if ($this->socket === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }
    }

    public function initClientSocket($domainSocket)
    {
        $address = dirname(__FILE__) . $domainSocket;
        if (socket_connect($this->socket, $address) === false) {
            echo "socket_connect() failed.\nReason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }
    }

    public function sendMsgToServer($msg = "Hi there, server!")
    {
        socket_write($this->socket, $msg, strlen($msg));
    }

    public function receiveMsgFromServer()
    {
        $output = socket_read($this->socket, 1024);
        if ($output === false) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        } else {
            echo "replay from server: " . $output . "\n";
        }
    }

    public function closeSocket()
    {
        socket_close($this->socket);
    }
}