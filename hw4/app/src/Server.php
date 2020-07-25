<?php

namespace SayHelloApp;


class Server
{
    private $socketFile;
    private $socket;
    private $enableDeamon = true;

    public function __construct(string $socketFile)
    {
        $this->socketFile = $socketFile;
        $this->connect();
    }

    private function connect(): void
    {
        $this->clearSocketFile();
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->socket, $this->socketFile);
        socket_listen($this->socket);

    }

    private function clearSocketFile(): void
    {
        if (file_exists($this->socketFile))

            unlink($this->socketFile);
    }

    public function runDeamon(): void
    {
        while ($this->enableDeamon) {
            if ($accept = socket_accept($this->socket)) {
                $message = trim(socket_read($accept, 2048));

                if ($message == "stop") {
                    $this->goodbye($accept);
                } elseif (!empty($message)) {
                    $this->sayHello($accept, $message);
                }
            } else {
                $this->enableDeamon = false;
            }
        }
    }

    private function sayHello($socketAccept, string $name): void
    {
        $message = "Привет, $name!" . PHP_EOL;
        socket_write($socketAccept, $message, strlen($message));
    }

    private function goodbye($socketAccept): void
    {
        $message = "Пока!" . PHP_EOL;
        socket_write($socketAccept, $message, strlen($message));
        $this->enableDeamon = false;
    }


    public function __destruct()
    {
        socket_close($this->socket);
        unlink($this->socketFile);
    }
}

