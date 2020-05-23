<?php

namespace HW4\Socket;


class Socket
{
    private int $domain;
    private int $type;
    private int $protocol;
    private string $address;
    private int $port;

    /** @var resource */
    private $socket;

    /**
     * Socket constructor.
     *
     * @param resource $socket
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @param string $address
     * @param int $port
     */
    public function __construct(
        $socket,
        int $domain,
        int $type,
        int $protocol,
        string $address,
        int $port = 0
    )
    {
        $this->socket = $socket;
        $this->domain = $domain;
        $this->type = $type;
        $this->protocol = $protocol;
        $this->address = $address;
        $this->port = $port;
    }

    /**
     * @return resource
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
        return ! $this->isValid();
    }
}