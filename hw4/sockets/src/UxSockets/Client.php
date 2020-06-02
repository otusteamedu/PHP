<?php

namespace UxSockets;

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

    public function runClient()
    {
        try {
            $this->connectToSocket();
            echo "Enter your message and press key \"Enter\"," . PHP_EOL .
            "For Exit type \"exit\" or \"quit\"," . PHP_EOL .
            "For shutdown Server&Client type \"shutdown\":" . PHP_EOL;
            do {
                $msg = fgetc(STDIN);
                $this->sendMesssage($msg);
                $this->receiveMessage();
            } while (strtolower($msg) !== 'exit' || strtolower($msg) !== 'quit' || strtolower($msg) !== 'shutdown');
            $this->closeSocket();
        } catch (\Exception $e) {
            echo "Exception: {$e->getMessage()}" . PHP_EOL;
            $log = new \UxSockets\Log\Log($this->getConfig()->getSettings()["error_log"]);
            $log->addLogNote($e->getMessage());
        }
    }
}
