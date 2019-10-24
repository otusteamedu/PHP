<?php

require_once "classes/SocketConfig.php";

abstract class SocketService
{
    protected $source;
    protected $config;

    /**
     * UnixSocket constructor.
     * @param SocketConfig $config
     * @throws Exception
     */
    public function __construct(SocketConfig $config)
    {
        $this->config = $config;
        if (!$this->source = socket_create(AF_UNIX, SOCK_DGRAM, 0)) $this->socketError();
    }

    abstract public function close();

    /**
     * @param $msg
     * @param $addr
     * @throws Exception
     */
    protected function sendTo(string $msg, string $addr)
    {
        if (!socket_set_nonblock($this->source)) $this->socketError();
        if (socket_sendto($this->source, $msg, strlen($msg), 0, $addr) === -1) $this->socketError();
    }

    /**
     * @param string $addr
     * @return string
     * @throws Exception
     */
    protected function receiveFrom(?string &$addr = null): string
    {
        if (!socket_set_block($this->source)) $this->socketError();
        if (socket_recvfrom($this->source, $response, 65536, 0, $addr) === -1) $this->socketError();
        return "{$response}";
    }

    /**
     * @throws Exception
     */
    protected function socketError()
    {
        throw new Exception(socket_strerror(socket_last_error($this->source)));
    }
}