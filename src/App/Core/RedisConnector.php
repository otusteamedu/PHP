<?php

namespace App\Core;

class RedisConnector
{
    private string $host = 'localhost';
    private int $port = 6379;
    private int $db = 0;

    /**
     * RedisConnector constructor.
     * @param string $linkStr
     */
    public function __construct(string $linkStr)
    {
        $this->buildFromLinkStr($linkStr);
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
     * @return RedisConnector
     */
    public function setHost(string $host): RedisConnector
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
     * @return RedisConnector
     */
    public function setPort(int $port): RedisConnector
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return int
     */
    public function getDb(): int
    {
        return $this->db;
    }

    /**
     * @param int $db
     * @return RedisConnector
     */
    public function setDb(int $db): RedisConnector
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @param string $linkStr
     */
    private function buildFromLinkStr(string $linkStr)
    {
        $url = parse_url($linkStr);
        $this->host = $url['host'] ?? $this->host;
        $this->port = intval($url['port'] ?? $this->port);
        $this->db = intval($url['db'] ?? $this->db);
    }
}