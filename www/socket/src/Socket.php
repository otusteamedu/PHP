<?php

namespace App;

use Exception;
use RuntimeException;

/**
 * Class Socket
 * @package App
 */
class Socket
{
    private $source;

    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function create()
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket)
            throw new Exception('Unable to create AF_UNIX socket');

        $this->source = $socket;

        return $this;
    }


    /**
     * @return $this
     * @throws Exception
     */
    public function bind()
    {
        if (!socket_bind($this->source, $this->filePath))
            throw new Exception("Unable to bind to $this->filePath");

        return $this;
    }

    /**
     * @return $this
     */
    public function block(): self
    {
        if (!socket_set_block($this->source)) {
            throw new RuntimeException("Can't set the socket lock");
        }

        return $this;
    }

    /**
     * @return string
     */
    public function receive(): string
    {
        $data = '';
        $from = '';

        if (socket_recvfrom($this->source, $data, 65536, MSG_WAITALL, $from) === false) {
            throw new RuntimeException('Error in receiving data from the socket.');
        }

        return "{$data}";
    }

    /**
     * @return $this
     */
    public function unblock(): self
    {
        if (!socket_set_nonblock($this->source)) {
            throw new RuntimeException("Can't get the socket lock off");
        }
        return $this;
    }

    /**
     * @param string $data
     * @param string $address
     * @return Socket
     */
    public function send(string $data, string $address): Socket
    {
        $len = strlen($data);
        $bytesSent = socket_sendto($this->source, $data, $len, MSG_WAITALL, $address);
        if ($bytesSent === false) {
            throw new RuntimeException('Error when sending data to the socket.');
        } elseif ($bytesSent != $len) {
            throw new RuntimeException($bytesSent . ' the byte was sent, expected ' . $len . ' byte');
        }

        return $this;
    }

    public function unbind(): void
    {
        socket_close($this->source);
        unlink($this->filePath);
    }
}
