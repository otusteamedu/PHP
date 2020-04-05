<?php

namespace Socket;

use Exception;

class UnixSocket
{
    /** @var resource */
    protected $socket;

    /** @var string */
    protected $filePath;

    /**
     * Socket constructor.
     * @param string $filePath
     * @throws Exception
     */
    public function __construct($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
            throw new Exception("Socket file $filePath already exists!");

        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (false === $socket) {
            throw new Exception('Failed to create unix socket');
        }

        if (!socket_bind($socket, $filePath, 0)) {
            throw new Exception("Failed to bind unix socket to address $filePath");
        }

        $this->filePath = $filePath;
        $this->socket = $socket;
    }


    public function close(): void
    {
        socket_close($this->socket);
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function read()
    {
        $message = '';
        $bytes = socket_recv($this->socket, $message, 65536, 0);

        if (false === $bytes) {
            throw new Exception('An error occurred. ' . socket_strerror(socket_last_error()));
        }

        return $message;
    }

    /**
     * @param string $message
     * @param string $address
     * @return bool
     * @throws Exception
     */
    public function sendTo(string $message, string $address): bool
    {
        if (!file_exists($address)) {
            throw new Exception('Does not exist destination unix-socket file');
        }
        $bytes = socket_sendto($this->socket, $message, strlen($message), 0, $address, 0);

        if (false === $bytes) {
            throw new Exception('An error occurred while sending the message.');
        }

        if ($bytes !== strlen($message)) {
            throw new Exception('The number of bytes sent is not equal to the size of the message');
        }

        return true;
    }
}