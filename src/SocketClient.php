<?php

namespace crazydope\socket;

class SocketClient extends Socket implements  SocketClientInterface
{
    /**
     * @param string $address
     * @return SocketClientInterface
     * @throws SocketException
     */
    public function connect(string $address): SocketClientInterface
    {
        $this->prepareAddress($address);
        $result = @socket_connect($this->resource, $this->address, $this->port);
        if ($result === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $this;
    }
}