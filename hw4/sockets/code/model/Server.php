<?php
/**
 * Description of Server.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Otus\Sockets;

require('Socket.php');

final class Server
{
    private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function listen()
    {

        do {
            $this->socket->accept();

            $message = $this->socket->readFromAccepted();

            if ($message === 'quit') {
                break;
            }
            echo "Client says:\t" . $message . PHP_EOL;

            echo "Enter Reply:\t";
            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        } while (true);

        $this->socket->close();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
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