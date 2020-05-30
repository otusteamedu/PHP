<?php

namespace UxSockets;
require_once "Server.php";

class Client extends Server
{
    private $socket; // resource

    public function __construct()
    {
        ob_implicit_flush();
        parent::__construct();
    }

    public function __destruct()
    {
        $this->log->addLogNote("Exit from client.");
        socket_close($this->socket);
    }

    public function connectToSocket(): void
    {
        $this->log->addLogNote("Connect to socket for message.");

        if (($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new \Exception("Socket not create: " . socket_strerror(socket_last_error()));
        }

        if (socket_connect($this->socket, $this->config->getSettings()["domainSocket"]) === false) {
            throw new \Exception("socket_connect() failed: " . socket_strerror(socket_last_error($this->socket)));
        } else {
            $this->log->addLogNote("Connection established successfully!");
        }
    }

    public function sendMesssage(string $msg = "Server - catch a message..."): void
    {
        if (socket_write($this->socket, $msg, strlen($msg)) === false) {
            throw new \Exception("Failed write to socket: " . socket_strerror(socket_last_error($this->socket)));
        }
        $this->log->addLogNote($msg);
    }

    public function receiveMessage(): void
    {
        $output = socket_read($this->socket, 1024);
        if ($output === false) {
            throw new \Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error($this->socket)));
        } else {
            echo "replay from server: " . $output . "\n";
        }
    }
}