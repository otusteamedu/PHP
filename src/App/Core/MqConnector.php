<?php

namespace App\Core;

class MqConnector
{
    private string $host = 'localhost';
    private int $port = 5672;
    private string $user = 'guest';
    private string $pass = 'guest';
    private string $exchange = '';

    /**
     * MqConnector constructor.
     * @param string $linkStr
     */
    public function __construct(string $linkStr)
    {
        $this->buildFromLink($linkStr);
    }

    /**
     * @return array
     */
    public function toAssoc()
    {
        return [
            'host'     => $this->host,
            'port'     => $this->port,
            'login'    => $this->user,
            'password' => $this->pass,
        ];
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return MqConnector
     */
    public function setHost(string $host): MqConnector
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return MqConnector
     */
    public function setPort(int $port): MqConnector
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return MqConnector
     */
    public function setUser(string $user): MqConnector
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return MqConnector
     */
    public function setPass(string $pass): MqConnector
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return string
     */
    public function getExchange(): string
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     * @return MqConnector
     */
    public function setExchange(string $exchange): MqConnector
    {
        $this->exchange = $exchange;
        return $this;
    }

    private function buildFromLink(string $link)
    {
        $url = parse_url($link);
        $this->port = $url['port'] ?? $this->port;
        $this->host = $url['host'] ?? $this->host;
        $this->user = $url['user'] ?? $this->user;
        $this->pass = $url['pass'] ?? $this->pass;
        $this->exchange = trim(
            str_replace('/', '.', $url['path'] ?? $this->exchange),
            '. \t\n\r\0\x0B'
        );
    }
}