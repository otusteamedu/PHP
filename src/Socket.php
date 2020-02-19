<?php

namespace App;

final class Socket
{
    private $sock;
    private string $bind = '';

    /**
     * Socket constructor.
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @throws SocketException
     */
    public function __construct(int $domain, int $type, int $protocol = 0)
    {
        // create unix udp socket
        $this->sock = @socket_create($domain, $type, $protocol);
        if (!$this->sock) {
            throw new SocketException('Unable to create AF_UNIX socket');
        }
    }

    /**
     * Socket denstructor.
     */
    public function __destruct()
    {
        @socket_close($this->sock);
        if (file_exists($this->bind)) {
            unlink($this->bind);
        }
    }

    /**
     * @param string $address
     * @param int $port
     * @return Socket
     * @throws SocketException
     */
    public function bind(string $address, int $port = 0): self
    {
        $this->bind = $address;
        if (!@socket_bind($this->sock, $address, $port)) {
            throw new SocketException('Unable to bind socket');
        }
        return $this;
    }

    /**
     * @return Socket
     * @throws SocketException
     */
    public function setBlock(): self
    {
        // use socket to send data
        if (!@socket_set_block($this->sock)) {
            throw new SocketException('Unable to set blocking mode for socket');
        }
        return $this;
    }

    /**
     * @return Socket
     * @throws SocketException
     */
    public function setNonBlock(): self
    {
        // use socket to send data
        if (!@socket_set_nonblock($this->sock)) {
            throw new SocketException('Unable to set nonblocking mode for socket');
        }
        return $this;
    }

    /**
     * @param string $msg
     * @param string $addr
     * @param int $port
     * @param int $flags
     * @return Socket
     * @throws SocketException
     */
    public function sendTo(string $msg, string $addr, int $port = 0, int $flags = 0): self
    {
        // at this point 'server' process must be running and bound to receive from serv.sock
        $len = strlen($msg);
        $bytes_sent = @socket_sendto($this->sock, $msg, $len, $flags, $addr, $port);
        if ($bytes_sent === -1) {
            throw new SocketException('An error occured while sending to the socket');
        }
        if ($bytes_sent !== $len) {
            throw new SocketException($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
        return $this;
    }

    /**
     * @param string $buf
     * @param string $name
     * @param int $len
     * @param int $flags
     * @param int $port
     * @return $this
     * @throws SocketException
     */
    public function recvFrom(string &$buf, string &$name, int $len = 65536, int $flags = 0, int $port = 0): self
    {
        $bytes_received = @socket_recvfrom($this->sock, $buf, $len, $flags, $name, $port);
        if ($bytes_received === -1) {
            throw new SocketException('An error occured while receiving from the socket');
        }
        return $this;
    }
}
