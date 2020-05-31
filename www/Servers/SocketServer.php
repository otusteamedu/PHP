<?php

use \Handler\ErrorClass;

class SocketServer {
    public $socket;

    public function __construct () 
    {
        $this->create();
    }

    public function create () 
    {
        if (!$this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)) $this->error();
    }    

    public function error (ErrorClass $error)
    {
        $error->write(socket_strerror(socket_last_error($this->source)));
    }
}
