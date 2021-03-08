<?php

namespace App\Sockets;

use App\Exceptions\SocketsException;

class Server
{
    /**
     * @var Socket
     */
    protected Socket $socket;

    /**
     * Server constructor.
     *
     * @param string $host
     * @param int $port
     *
     * @throws SocketsException
     */
    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    /**
     * @throws SocketsException
     */
    public function listen()
    {
        do {
            echo "Server is listening...\n";

            $this->socket->accept();

            $message = $this->socket->readFromAccepted();

            if ($message === 'quit') {
                break;
            }

            echo "Client says:\t" . $message . "\n\n";

            echo "Enter Reply:\t";
            $reply = $this->readline();
            $this->socket->writeToAccepted($reply);
        } while (true);

        $this->socket->close();
    }

    /**
     * @param string $host
     * @param int $port
     *
     * @throws SocketsException
     */
    protected function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->clearOldSocket();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
    }

    /**
     * Gets user input.
     *
     * @return string
     */
    protected function readline(): string
    {
        return rtrim(fgets(STDIN));
    }
}
