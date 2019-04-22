<?php

namespace crazydope\socket;

class Socket implements SocketInterface
{
    /**
     * @var resource
     */
    protected $resource;
    /**
     * @var string
     */
    protected $address;
    /**
     * @var int
     */
    protected $port = 80;

    /**
     * @param string $address
     */
    protected function prepareAddress(string $address): void
    {
        $this->address = $address;
        $colon = strrpos($address, ':');

        if ($colon !== false) {
            $this->port = (int)substr($address, $colon + 1);
            $this->address = substr($address, 0, $colon);
        }
    }

    /**
     * @param null|resource $resource
     * @return string
     */
    public static function getErrorMessage($resource = null): string
    {
        $code = $resource === null ? socket_last_error() : socket_last_error($resource);
        socket_clear_error();

        $string = socket_strerror($code);

        foreach (get_defined_constants() as $key => $value) {
            if ($value === $code && strpos($key, 'SOCKET_') === 0) {
                $string .= ' (' . $key . ')';
                break;
            }
        }
        return $string;
    }

    /**
     * Socket constructor.
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param int $level
     * @param int $name
     * @return mixed
     * @throws SocketException
     */
    public function getOption(int $level, int $name)
    {
        $value = @socket_get_option($this->resource, $level, $name);
        if ($value === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $value;
    }

    /**
     * @param int $level
     * @param int $name
     * @param $optVal
     * @return bool
     * @throws SocketException
     */
    public function setOption(int $level, int $name, $optVal): bool
    {
        $value = @socket_set_option($this->resource, $level, $name,$optVal);
        if ($value === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $value;
    }

    /**
     * @return SocketInterface
     */
    public function close(): SocketInterface
    {
        socket_close($this->resource);
        return $this;
    }

    /**
     * @param string $buffer
     * @return int
     * @throws SocketException
     */
    public function write(string $buffer): int
    {
        $return = @socket_write($this->resource, $buffer);
        if ($return === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $return;
    }

    /**
     * @param int $length
     * @param int $type
     * @return string
     * @throws SocketException
     */
    public function read(int $length, int $type = PHP_BINARY_READ): string
    {
        $data = @socket_read($this->resource, $length, $type);
        if ($data === false) {
            throw new SocketException(self::getErrorMessage($this->resource));
        }
        return $data;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}