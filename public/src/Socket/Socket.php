<?php

declare(strict_types=1);

namespace Socket\Ruvik\Socket;

use Socket\Ruvik\Exception\RuntimeException;

class Socket
{
    /** @var resource */
    private $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function bind(string $ip, int $port = 0): self
    {
        $result = socket_bind($this->resource, $ip, $port);
        if ($result === false) {
            throw new RuntimeException($this->getErrorMessage());
        }
        return $this;
    }

    /**
     * @param int $level
     * @param int $optionName
     * @param mixed $optionValue
     * @return $this
     */
    public function setOption(int $level, int $optionName, $optionValue): self
    {
        $result = socket_set_option($this->resource, $level, $optionName, $optionValue);
        if ($result === false) {
            throw new RuntimeException($this->getErrorMessage());
        }
        return $this;
    }

    public function listen(): self
    {
        $result = socket_listen($this->resource);
        if ($result === false) {
            throw new RuntimeException($this->getErrorMessage());
        }
        return $this;
    }

    public function listen2()
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException("Unable to set blocking mode for socket {$this->getName()}");
        }

        $bytesReceived = socket_recvfrom($this->socket, $buf, $length, $flags, $name, $port);

        if ($bytesReceived === false || $bytesReceived === -1) {
            throw new RuntimeException("An error occurred while receiving from the socket {$this->getName()}");
        }

        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException("Unable to set non-blocking mode for socket {$this->getName()}");
        }

        return $bytesReceived;
    }

    public function accept(): self
    {
        $result = socket_accept($this->resource);
        if ($result === false) {
            throw new RuntimeException($this->getErrorMessage());
        }
        return new Socket($result);
    }

    public function connect(string $ip, int $port = 0): self
    {
        $result = socket_connect($this->resource, $ip, $port);
        if ($result === false) {
            throw new RuntimeException($this->getErrorMessage());
        }
        return new Socket($result);
    }

    public function close(): self
    {
        socket_close($this->resource);
        return $this;
    }

    public function read($length = 2024): string
    {
        return socket_read($this->resource, 2024);
    }

    public function write($buffer): int
    {
        $ret = socket_write($this->resource, $buffer);
        if ($ret === false) {
            $this->getErrorMessage('error write');
        }
        return $ret;
    }

    public function sendTo($buffer, $flags, $remoteAddress)
    {
        $ret = socket_sendto($this->resource, $buffer, strlen($buffer), $flags, $remoteAddress);
        if ($ret === false) {
            $this->getErrorMessage('error sendTo');
        }
        return $ret;
    }

    private function getErrorMessage(): string
    {
        return socket_strerror(socket_last_error($this->resource));
    }
}
