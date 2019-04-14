<?php

namespace crazydope\socket;

class SocketServer extends Socket implements SocketServerInterface
{
    /**
     * @return SocketInterface
     * @throws SocketException
     */
    public function accept(): SocketInterface
    {
        $resource = @socket_accept($this->resource);
        if ($resource === false) {
            throw new SocketException(self::getErrorMessage());
        }
        return new Socket($resource);
    }

    /**
     * @param string $address
     * @return SocketServerInterface
     * @throws SocketException
     */
    public function bind(string $address): SocketServerInterface
    {
        $this->prepareAddress($address);
        $bind = @socket_bind($this->resource, $this->address, $this->port);
        if ($bind === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $this;
    }

    /**
     * @param int $backlog
     * @return SocketServerInterface
     * @throws SocketException
     */
    public function listen(int $backlog = 0): SocketServerInterface
    {
        $result = @socket_listen($this->resource, $backlog);
        if ($result === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $this;
    }
}