<?php

namespace HW4\Socket;


class Socket
{
    private int $domain;
    private int $type;
    private int $protocol;
    private string $address;
    private int $port = 0;

    /** @var resource */
    private $socket;

    /**
     * Socket constructor.
     *
     * @param resource $socket
     */
    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    /**
     * @param int $domain
     *
     * @return Socket
     */
    public function setDomain(int $domain): Socket
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param int $type
     *
     * @return Socket
     */
    public function setType(int $type): Socket
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int $protocol
     *
     * @return Socket
     */
    public function setProtocol(int $protocol): Socket
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @param string $address
     *
     * @return Socket
     */
    public function setAddress(string $address): Socket
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param int $port
     *
     * @return Socket
     */
    public function setPort(int $port): Socket
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return resource
     * @throws SocketException
     */
    public function getValidSocketResource()
    {
        if ($this->isNotValid()) {
            throw new SocketException('Sockets resource not found.');
        }

        return $this->socket;
    }

    /**
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @return int
     */
    public function getDomain(): int
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getProtocol(): int
    {
        return $this->protocol;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !empty($this->socket) && is_resource($this->socket);
    }

    /**
     * @return bool
     */
    public function isNotValid(): bool
    {
        return !$this->isValid();
    }
}