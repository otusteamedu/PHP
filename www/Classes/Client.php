<?php

namespace Classes;

class Client {
    private $sock;
    private $connect;
    private $host;
    private $port;

    public function __construct (String $host, String $port) 
    {
        if (!empty($host) && !empty($port)) {
            $this->host = $host;
            $this->port = $port;

            $this->connect();
        } else {
            $this->error("no connect\n");
        }
    }

    private function connect () 
    {
        if (!$this->sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) $this->error("Client: Clould not create socket\n");
        if (!$this->connect = socket_connect($this->sock, $this->host, $this->port)) $this->error("Client error connect");
    }

    public function send ($msg)
    {
        socket_write($this->sock, $msg, strlen($msg));
    }    

    public function response () {
        return "Server says:\t" . trim(socket_read($this->sock, 1924));
    }

    private function error (String $msg)
    {
        echo $msg . "\n";
        die;
    }
}


