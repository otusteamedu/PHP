<?php
declare(strict_types=1);

namespace App\Socket;

use App\Socket\Exception\SocketException;

/**
 * Class AbstractSocket
 */
abstract class AbstractSocket
{
    /**
     * @var \Socket|null
     */
    protected ?\Socket $socket = null;

    /**
     * @param int $domain
     * @param int $type
     * @param int $protocol
     *
     * @throws SocketException When unable to create socket.
     */
    public function __construct(
        protected int $domain = AF_UNIX,
        int $type = SOCK_STREAM,
        int $protocol = 0,
    )
    {
        if (!$socket = socket_create($domain, $type, $protocol)) {
            throw $this->createExceptionWithErrorCode('Unable to create socket');
        }

        $this->socket = $socket;
    }

    /**
     * @param string $buffer
     *
     * @return int The number of bytes successfully written to the socket.
     *
     * @throws SocketException When unable to write to socket.
     */
    public function write(string $buffer): int
    {
        $bytes = socket_write($this->socket, $buffer);

        if ($bytes === false) {
            throw $this->createExceptionWithErrorCode('Unable to write to socket');
        }

        return $bytes;
    }

    /**
     * @return void
     */
    public function close(): void
    {
        socket_close($this->socket);
    }

    /**
     * Reads all bytes written to socket.
     *
     * @return string
     *
     * @throws SocketException When unable to read from socket.
     */
    public function readAll(): string
    {
        $content = '';

        $read = [$this->socket];

        socket_select($read, $write, $except, null);

        while (true) {
            $changedSockets = socket_select($read, $write, $except, 0);

            if ($changedSockets === false) {
                throw $this->createExceptionWithErrorCode('Unable to read from socket');
            }

            if ($changedSockets <= 0) {
                break;
            }

            if (false === ($buf = socket_read($this->socket, 1024))) {
                throw $this->createExceptionWithErrorCode('Unable to read from socket');
            }

            $content .= trim($buf);
        }

        return $content;
    }

    /**
     * @param string $message
     *
     * @return SocketException
     */
    protected function createExceptionWithErrorCode(string $message): SocketException
    {
        $errorCode = socket_last_error($this->socket);

        return new SocketException(
            sprintf(
                '%s: [%d] %s.',
                $message,
                $errorCode,
                socket_strerror($errorCode)
            ),
            0
        );
    }
}
