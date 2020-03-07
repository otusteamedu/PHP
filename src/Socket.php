<?php

class Socket
{
    /**
     * @var false|resource
     */
    private $socket;

    /**
     * @var string
     */
    private $address;

    /**
     * Socket constructor.
     * @param string $address
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @throws Exception
     */
    public function __construct(string $address, int $domain = SOCK_STREAM, int $type = SOCK_DGRAM, int $protocol = 0)
    {
        $this->address = $address;
        if (file_exists($this->address)) {
            unlink($this->address);
        }
        $this->socket = socket_create($domain, $type, $protocol);
        if (!$this->socket) {
            throw new Exception('Unable to create socket');
        }
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->address)) {
            $errorCode = socket_last_error();
            $errorMsg = socket_strerror($errorCode);
            echo "Не могу создать сокет: [$errorCode] $errorMsg";
            throw new Exception('Unable to bind to $this->address');
        };
    }

    /**
     * @throws Exception
     */
    public function setBlock()
    {
        if (socket_set_block($this->socket) === false) {
            $this->throwException();
        }
    }

    /**
     * @throws Exception
     */
    public function setNonblock()
    {
        if (!socket_set_nonblock($this->socket)) {
            $this->throwException();
        }
    }

    /**
     * @param string $buf
     * @param string $address
     * @return false|int
     * @throws Exception
     */
    public function send(string $buf, string $address)
    {
        $len = strlen($buf);
        $bytesSent = socket_sendto($this->socket, $buf, $len, 0, $address);
        if ($bytesSent === false) {
            $this->throwException();
        }
        return $bytesSent;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get(): array
    {
        $bytesReceived = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytesReceived == -1) {
            $this->throwException();
        }
        return [$buf, $from];
    }

    /**
     * @throws Exception
     */
    private function throwException()
    {
        $errorCode = socket_last_error();
        $errorMsg = socket_strerror($errorCode);
        throw new Exception($errorMsg, $errorCode);
    }

    public function close(): void
    {
        socket_close($this->socket);
        if (file_exists($this->address)) {
            unlink($this->address);
        }
    }
}