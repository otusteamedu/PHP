<?php

class Server
{
    private SocketServer $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function listen(): void
    {
        do {
            $this->socket->accept();
            $message = $this->socket->readFromAccepted();
            if ($message === 'Завершить') {
                break;
            }
            echo "Сообщение клиента:\t" . $message . "\n";

            echo "Введите ответ:\t";
            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        } while (true);

        $this->socket->close();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new SocketServer($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }
}