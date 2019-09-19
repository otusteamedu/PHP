<?php

namespace App\Socket;

use Exception;

class UnixSocket
{
    private $socket;
    private $file;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (! extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (! $this->socket) {
            throw new Exception('Unable to create socket');
        }
    }

    /**
     * @param string $file
     * @return $this
     * @throws Exception
     */
    public function bind(string $file)
    {
        $this->removeSocketFile($file);

        if (! socket_bind($this->socket, $file)) {
            throw new Exception("Unable to bind to $file");
        }

        $this->file = $file;

        return $this;
    }

    /**
     * @return UnixSocket
     * @throws Exception
     */
    public function setBlock()
    {
        if (! socket_set_block($this->socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        return $this;
    }

    /**
     * @return UnixSocket
     * @throws Exception
     */
    public function setNonBlock()
    {
        if (! socket_set_nonblock($this->socket)) {
            throw new Exception('Unable to set nonblocking mode for socket');
        }

        return $this;
    }

    /**
     * @param int $length
     * @return ReceivedMessage
     * @throws Exception
     */
    public function receive(int $length = 65535)
    {
        $buf = '';
        $from = '';

        $received = socket_recvfrom($this->socket, $buf, $length, 0, $from);

        if ($received == -1) {
            throw new Exception('An error occured while receiving from the socket');
        }

        return new ReceivedMessage($buf, $from, $received);
    }

    /**
     * @param string $message
     * @param string $to
     * @return int
     * @throws Exception
     */
    public function send(string $message, string $to)
    {
        $sentBytes = socket_sendto($this->socket, $message, mb_strlen($message), 0, $to);

        if ($sentBytes === false) {
            throw new Exception('An error occured while sending to the socket');
        }

        return $sentBytes;
    }

    /**
     * @return void
     */
    public function close()
    {
        socket_close($this->socket);

        $this->removeSocketFile($this->file);
    }

    /**
     * @param string $file
     * @return void
     */
    protected function removeSocketFile(string $file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
