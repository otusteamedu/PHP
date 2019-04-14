<?php

namespace crazydope\socket;

 use \InvalidArgumentException;

class SocketFactory implements SocketFactoryInterface
{
    protected const DOMAIN_TCP = 'tcp';
    protected const DOMAIN_UNIX = 'unix';

    public const SERVER = 1;
    public const CLIENT = 2;

    /**
     * @var int
     */
    protected $type;

    /**
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @return SocketClient|SocketServer
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    protected function create(int $domain, int $type, int $protocol)
    {
        $resource = @socket_create($domain, $type, $protocol);

        if (!is_resource($resource)) {
            throw new SocketException(Socket::getErrorMessage($resource));
        }

        if ($this->type === self::CLIENT) {
            return new SocketClient($resource);
        }

        if ($this->type === self::SERVER) {
            return new SocketServer($resource);
        }

        throw new InvalidArgumentException('Invalid type given.');
    }

    /**
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    protected function createTcp()
    {
        return $this->create(AF_INET, SOCK_STREAM, SOL_TCP);
    }

    /**
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    protected function createUnix()
    {
        return $this->create(AF_UNIX, SOCK_STREAM, 0);
    }

    /**
     * @param $address
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    protected function make(&$address)
    {
        $pos = strpos($address, '://');
        if ($pos === false) {
            throw new InvalidArgumentException('Invalid scheme given.');
        }

        $scheme = strtolower(substr($address, 0, $pos));
        $address = substr($address, $pos + 3);

        if ($scheme === self::DOMAIN_TCP) {
            return $this->createTcp();
        }

        if ($scheme === self::DOMAIN_UNIX) {
            return $this->createUnix();
        }

        throw new InvalidArgumentException('Scheme not supported.');

    }

    /**
     * SocketFactory constructor.
     * @param int $type
     */
    public function __construct(int $type = self::SERVER)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return SocketFactoryInterface
     */
    public function setType(int $type): SocketFactoryInterface
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @param string $address
     * @return SocketClientInterface|SocketServerInterface
     * @throws SocketException
     */
    public function createFromString(string $address)
    {
        $socket = $this->make($address);

        try {
            switch ($this->type) {
                case self::CLIENT:
                    $socket->connect($address);
                    break;
                case self::SERVER:
                    $socket->bind($address);
                    if ($socket->getOption(SOL_SOCKET, SO_TYPE) === SOCK_STREAM) {
                        $socket->listen();
                    }
                    break;
                default:
                    throw new InvalidArgumentException('Invalid type given.');
            }
        } catch (SocketException $e) {
            $socket->close();
            throw $e;
        }

        return $socket;
    }
}