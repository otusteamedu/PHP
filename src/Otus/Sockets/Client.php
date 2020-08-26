<?php

/**
 * Description of Client.php
 * @copyright Copyright (c) eapdob
 * @author    Evgenii Poperezhay <eapdob@gmail.com>
 */

namespace Otus\Sockets;

final class Client
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function connect(): void
    {
        do {
            $this->message();
            $this->waitingResponse();
        } while (true);

        $this->socket->close();
    }

    public function test()
    {
        echo "Client working...";
    }

    private function message(): void
    {
        echo "Client enter message:\t";
        $message = $this->readLine();
        $this->socket->write($message);
    }

    private function initSocket($host, $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create();
        $this->socket->connect();
    }

    private function waitingResponse(): void
    {
        echo "server message was:\t" . $this->socket->read() . "\n\n";
    }

    private function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }
}