<?php

class Client
{
    private SocketClient $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function waitForMessage(): void
    {
        echo "Введите сообщение:\t";
        $this->message($this->readline());
    }

    public function message(string $message): void
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new SocketClient($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->connect();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    private function waitingResponse(): void
    {
        echo "Ответ сервера:\t" . $this->socket->read();
    }

}