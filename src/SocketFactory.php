<?php

namespace crazydope\socket;

 use \InvalidArgumentException;

class SocketFactory implements SocketFactoryInterface
{
    protected const DOMAIN_TCP = 'tcp';
    protected const DOMAIN_UNIX = 'unix';

    /**
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @return resource
     * @throws SocketException
     */
    protected function create(int $domain, int $type, int $protocol)
    {
        $resource = @socket_create($domain, $type, $protocol);
        if (!is_resource($resource)) {
            throw new SocketException(Socket::getErrorMessage($resource));
        }
        return $resource;
    }

    /**
     * @param bool $client
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    protected function createTcp(bool $client)
    {
        $resource = $this->create(AF_INET, SOCK_STREAM, SOL_TCP);
        return $client ? new SocketClient($resource) : new SocketServer($resource);
    }

    /**
     * @param bool $client
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    protected function createUnix(bool $client)
    {
        $resource = $this->create(AF_UNIX, SOCK_STREAM, 0);
        return $client ? new SocketClient($resource) : new SocketServer($resource);
    }

    /**
     * @param $address
     * @param bool $client
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    protected function make(&$address, bool $client = false)
    {
        $pos = strpos($address, '://');
        if ($pos === false) {
            throw new InvalidArgumentException('Invalid scheme given.');
        }

        $scheme = strtolower(substr($address, 0, $pos));
        $address = substr($address, $pos + 3);

        if ($scheme === self::DOMAIN_TCP) {
            return $this->createTcp($client);
        }

        if ($scheme === self::DOMAIN_UNIX) {
            return $this->createUnix($client);
        }

        throw new InvalidArgumentException('Scheme not supported.');
    }

    /**
     * @param string $address
     * @return SocketClientInterface
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    public function createClient(string $address): SocketClientInterface
    {
        $socket = $this->make($address, true);

        try {
            $socket->connect($address);
        } catch (SocketException $e) {
            $socket->close();
            throw $e;
        }

        return $socket;
    }

    /**
     * @param string $address
     * @return SocketServerInterface
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    public function createServer(string $address): SocketServerInterface
    {
        $socket = $this->make($address);

        try {
            $socket->setOption(SOL_SOCKET, SO_REUSEADDR, 1);
            $socket->bind($address);
            if ($socket->getOption(SOL_SOCKET, SO_TYPE) === SOCK_STREAM) {
                $socket->listen();
            }
        } catch (SocketException $e) {
            $socket->close();
            throw $e;
        }

        return $socket;
    }
}