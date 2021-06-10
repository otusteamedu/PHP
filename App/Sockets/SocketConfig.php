<?php


namespace App\Sockets;


class SocketConfig
{
    private int $port = 0;
    private ?string $address = null;
    private int $domain = AF_INET;
    private int $type = SOCK_STREAM;
    private int $protocol = 0;


    /**
     * @param string $address
     * @return SocketConfig
     */
    public function setAddress(string $address): SocketConfig
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param int $domain
     * @return SocketConfig
     */
    public function setDomain(int $domain): SocketConfig
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param int $port
     * @return SocketConfig
     */
    public function setPort(int $port): SocketConfig
    {
        $this->port = $port;
        return $this;

    }

    /**
     * @param int $protocol
     * @return SocketConfig
     */
    public function setProtocol(int $protocol): SocketConfig
    {
        $this->protocol = $protocol;
        return $this;

    }

    /**
     * @param null $type
     * @return SocketConfig
     */
    public function setType($type): SocketConfig
    {
        $this->type = $type;
        return $this;

    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getDomain(): int
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return int
     */
    public function getProtocol(): int
    {
        return $this->protocol;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }
}