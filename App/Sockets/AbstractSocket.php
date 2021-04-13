<?php


namespace App\Sockets;


use App\Sockets\Exceptions\SocketNotReadable;
use App\Sockets\Interfaces\iSocketConnected;

abstract class AbstractSocket implements iSocketConnected
{


    /**
     * @return null
     */
    abstract protected function getSocket();

    public function write(string $message): iSocketConnected
    {
        socket_write(
            $this->getSocket(),
            $message,
            strlen($message)
        );
        return $this;
    }

    public function close()
    {
        socket_close($this->getSocket());
    }

    public function shutdown(int $mode = 2)
    {
        socket_shutdown($this->getSocket(), $mode);
        return $this;
    }

    public function read($length = 1024, $type = PHP_BINARY_READ): ?string
    {
        $buffer = socket_read($this->getSocket(), $length, $type);

        if ($buffer === false) {
            throw new SocketNotReadable();
        }
        return $buffer === '' ? null : $buffer;
    }

    public function setTimeout(int $seconds, int $microseconds = 0): bool
    {
        return socket_set_timeout($this->getSocket(), $seconds, $microseconds);
    }

    public function getLastError()
    {
        return socket_last_error($this->getSocket());
    }

    public function getErrorString(): string
    {
        return socket_strerror($this->getLastError());
    }

}