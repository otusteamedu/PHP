<?php
declare(strict_types=1);

namespace App\Socket;

use App\Socket\Exception\SocketException;

/**
 * Class ServerSocket
 */
class ServerSocket extends AbstractSocket
{
    /**
     * @var \Socket|null
     */
    private ?\Socket $defaultSocket = null;

    /**
     * {@inheritDoc}
     */
    public function readAll(): string
    {
        if ($this->defaultSocket === null) {
            if (!$acceptedSocket = socket_accept($this->socket)) {
                throw $this->createExceptionWithErrorCode('Unable to accept socket');
            }

            $this->defaultSocket = $this->socket;
            $this->socket = $acceptedSocket;
        }

        return parent::readAll();
    }

    /**
     * @param string $address
     * @param int    $port
     *
     * @return void
     *
     * @throws SocketException When unable to bind socket.
     */
    public function bind(string $address, int $port = 0): void
    {
        if ($this->domain === AF_UNIX) {
            $this->removeOldSocketFile($address);
        }

        if (!socket_bind($this->socket, $address, $port)) {
            throw $this->createExceptionWithErrorCode('Unable to bind socket');
        }
    }

    /**
     * @param int $maxConnections
     *
     * @return void
     *
     * @throws SocketException When unable to listen socket.
     */
    public function listen(int $maxConnections = 1): void
    {
        if (!socket_listen($this->socket, $maxConnections)) {
            throw $this->createExceptionWithErrorCode('Unable to listen socket');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function close(): void
    {
        parent::close();

        if ($this->defaultSocket !== null) {
            socket_close($this->defaultSocket);
        }
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function removeOldSocketFile(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
