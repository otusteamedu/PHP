<?php
namespace Hw4;

use Hw4\Exception;

class Socket {

    private $resource;
    private $fileLocation;

    public function __construct() {
        if (!extension_loaded('sockets')) {
            throw new \Exception("Can't load the socket extension");
        }

        $create = @socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($create === false) {
            throw new \Exception("Can't create socket");
        }
        $this->resource = $create;
    }

    public function setSocketFileLocation($fileLocation) {
        $this->fileLocation = $fileLocation;
    }

    public function getResource() {
        return $this->resource;
    }

    /**
     * socket_bind()
     */
    public function bind() {
        $bind = @socket_bind($this->resource, $this->fileLocation);
        if ($bind === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $this;
    }

    /**
     * socket_connect()
     */
    public function connect() {
        var_dump($this->fileLocation);
        $connection = @socket_connect($this->resource, $this->fileLocation);
        if ($connection === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $this;
    }

    /**
     * socket_listen()
     */
    public function listen($backlog = 0)
    {
        $listen = @socket_listen($this->resource, $backlog);
        if ($listen === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $this;
    }

    /**
     * socket_set_block()
     * socket_set_nonblock()
     */
    public function setBlocking($toggle = true) {
        $blocking = $toggle ? @socket_set_block($this->resource) : @socket_set_nonblock($this->resource);
        if ($blocking === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $this;
    }

    /**
     * socket_recvfrom()
     */
    public function recvFrom($length, &$from) {
        $recv = @socket_recvfrom($this->resource, $buffer, $length, $flags = 0, $from);
        if ($recv === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $buffer;
    }

    /**
     * socket_sendto()
     */
    public function sendTo($buffer, $remote)
    {
        $sendRes = @socket_sendto($this->resource, $buffer, strlen($buffer), $flags = 0, $remote);
        if ($sendRes === false) {
            throw Exception::fromSocketResource($this->resource);
        }
        return $sendRes;
    }

    /**
     * socket_close()
     */
    public function close() {
        socket_close($this->resource);
        unlink($this->fileLocation);
        return $this;
    }

}