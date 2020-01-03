<?php

namespace Tirei01\Hw4\Socket;

abstract class Socket
{
    private $socket;
    private $patToSocket;
    protected $from;
    protected $buf;

    /**
     * Serv constructor.
     *
     * @param string $socketName
     *
     * @throws \Exception
     */
    public function __construct($socketName = "socket_def")
    {
        $this->setPath($socketName);
        if (file_exists($this->getPath())) {
            unlink($this->getPath());
        }
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            $this->throwException();
        }
        $this->from = "";
        $this->buf = "";
    }

    public function getPath()
    {
        return $this->patToSocket;
    }

    protected function setPath($socketName)
    {
        $this->patToSocket = sys_get_temp_dir() . "/" . $socketName . ".sock";
    }

    /**
     * @throws \Exception
     */
    public function bind(): void
    {
        if (!\socket_bind($this->socket, $this->getPath())) {
            $this->throwException();
        }
    }

    /**
     * @throws \Exception
     */
    public function block(): void
    {
        if (socket_set_block($this->socket) === false) {
            $this->throwException();
        }
    }

    public function nonBlock()
    {
        if (!socket_set_nonblock($this->socket)) {
            $this->throwException();
        }
    }

    public function send($buf, $to)
    {
        $len = strlen($buf);
        $bytes_sent = socket_sendto($this->socket, $buf, $len, 0, $to);
        if ($bytes_sent === false) {
            $this->throwException();
        }
    }

    public function get()
    {
        $bytes_received = socket_recvfrom($this->socket, $this->buf, 65536, 0, $this->from);
        if ($bytes_received == -1) {
            $this->throwException();
        }
    }

    public function getMessage()
    {
        return "[" . $this->from . "]:" . $this->buf;
    }

    public function close()
    {
        \socket_close($this->socket);
        if (file_exists($this->getPath())) {
            \unlink($this->getPath());
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    protected function throwException()
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        throw new \Exception($errormsg, $errorcode);
    }

    abstract public function loop();
}