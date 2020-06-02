<?php

namespace UxSockets;

use UxSockets\Ini\Ini;
use UxSockets\Log\Log;

class Server
{
    private $socket; // resource
    protected Log $log;
    protected Ini $config;
    protected int $Shutdown = 0;
    protected $msgSocket; // resource

    public function __construct()
    {
        $this->config = new Ini("config.ini");
        $this->log = new Log($this->config->getSettings()["event_log"]);
    }

    public function __destruct()
    {
        $this->log->addLogNote("Stop server.");

        socket_close($this->socket);
        if (file_exists($this->config->getSettings()['domainSocket'])) {
            unlink($this->config->getSettings()['domainSocket']);
        }
    }


    public function upServer(): void
    {
        $this->socket = socket_create(
            $this->config->getSettings()["domain"],
            $this->config->getSettings()["type"],
            $this->config->getSettings()["protocol"]
        );

        if ($this->socket === false) {
            throw new \Exception("socket_create() failed: " . socket_strerror(socket_last_error()));
        }

        if (socket_set_nonblock($this->socket) === false) {
            throw new \Exception("Failed to set mode for socket socket_set_nonblock: "
                . socket_strerror(socket_last_error()));
        }

        if (socket_bind($this->socket, $this->config->getSettings()["domainSocket"]) === false) {
            throw new \Exception("Socket not bind: " . socket_strerror(socket_last_error()));
        }

        if (socket_listen($this->socket, 7) === false) {
            throw new \Exception("Error execute socket_listen: " . socket_strerror(socket_last_error()));
        }


        $this->log->addLogNote("Server upstart!");
    }

    public function getConfig(): Ini
    {
        return $this->config;
    }

    public function sendAndRecieveMessage(): void
    {
        while (!$this->Shutdown) {
            $this->msgSocket = socket_accept($this->socket);

            if ($this->msgSocket === false) {
                usleep(100); // timeout reconnect
            } elseif ($this->msgSocket > 0) {
                $this->log->addLogNote("Client connected successfully!");
                $this->workWithMessage() ? $this->Shutdown = 0 : $this->Shutdown = 1;
            } else {
                throw new \Exception("Don't get connection socket_accept: "
                                    . socket_strerror(socket_last_error($this->socket)));
            }
        }
    }

    public function workWithMessage(): bool
    {
        $msgFromClient = socket_read($this->msgSocket, 1024);
 
        if ($msgFromClient === false) {
            throw new \Exception("socket_read() failed: "
                                . socket_strerror(socket_last_error($this->socket)));
        } elseif (
            strtolower($msgFromClient) === 'shutdown' ||
            strtolower($msgFromClient) === 'exit'     ||
            strtolower($msgFromClient) === 'quit'
        ) {
            return false;
        }

        $output = "Your message is: " . $msgFromClient . PHP_EOL;
        if (socket_write($this->msgSocket, $output) === false) {
            throw new \Exception("socket_write() failed: "
                                . socket_strerror(socket_last_error($this->msgSocket)));
        }

        $this->log->addLogNote($output);
        return true;
    }

    public function closeSocket(): void
    {
        if (isset($this->socket)) {
            socket_close($this->socket);
        } else {
            $this->log->addLogNote("Your seans successfully ended!");
        }
    }

    public function runServer(): void
    {
        try {
            $this->upServer();
            $this->sendAndRecieveMessage();
            $this->closeSocket();
        } catch (\Exception $e) {
            echo "Exception: {$e->getMessage()}" . PHP_EOL;
            $log = new Log($this->getConfig()->getSettings()["error_log"]);
            $log->addLogNote($e->getMessage());
        }
    }
}
