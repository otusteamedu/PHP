<?php

/**
 * Description of Server.php
 * @copyright Copyright (c) eapdob
 * @author    Evgenii Poperezhay <eapdob@gmail.com>
 */

namespace Otus\Sockets;

final class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function listen(): void
    {
        $this->socket->accept();

        do {
            $message = $this->socket->readFromAccepted();

            if ($message === 'quit') {
                break;
            }

            echo "client message was:\t" . $message . "\n\n";
            echo "Server enter message:\t";

            $answer = $this->readLine();

            $this->socket->writeToAccepted($answer);
        } while (true);

        $this->socket->close();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clear();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    private function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }
}