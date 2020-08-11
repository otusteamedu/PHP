<?php

namespace nlazarev\hw4\Model\Sockets;

class ClientUnixSocket extends UnixSocket
{
    protected static $socket_send_flags = MSG_DONTROUTE;
    protected static $socket_read_buf = 2048;
    protected static $socket_read_type = PHP_BINARY_READ;

    public function __construct()
    {
        parent::__construct();
        
        if ($this->ext_loaded
         && get_resource_type($this->instance) == "Socket") {
            $this->socket_ok = true;
        }
    }

    public function connect(string $path_to_socket): bool
    {
        $socket = $this->instance;
        if (@socket_connect($socket, $path_to_socket)) {
            return true;
        } else {
            $this->setErrorMsg();
            return false;
        }          
    }

    public function sendMsg(string $msg): bool
    {
        $socket = $this->instance;
        $len = strlen($msg);
        if (@socket_send($socket, $msg, $len, static::$socket_send_flags)) {
            return true;
        } else {
            $this->setErrorMsg();
            return false;
        }
    }

    public function readMsg(): ?string
    {
        $socket = $this->instance;
        if ($data = @socket_read($socket, static::$socket_read_buf, static::$socket_read_type)) {
            return $data;
        } else {
            $this->setErrorMsg();
            return null;         
        }
    }
}