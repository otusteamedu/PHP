<?php
namespace Servers;

class Socket {
    private $sock;
    private $bind;
    private $accept;
    private $host;
    private $port;

    public function __construct (String $host, String $port) 
    {
        if (!empty($host) && !empty($port)) {
            $this->host = $host;
            $this->port = $port;

            $this->create();
        } else {
            $this->error("no host or port specified\n");
        }
    }

    private function create () 
    {
        if (!$this->sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) $this->error("Clould not create socket\n");
        if (!$this->bind = socket_bind($this->sock, $this->host, $this->port)) $this->error("Clould not bind to socket\n");
    }    

    public function listen () 
    {
        if (!$this->bind = socket_listen($this->sock, 3)) {
            $this->error("Cloud not set up socket listner");

            die;
        }

        echo "Listening for connections";

        do {
            if (!$this->accept = socket_accept($this->sock)) {
                $this->error("Cloud not set up socket listner\n");

                die;
            }

            if (!$msg = socket_read($this->accept, 1024)) {
                $this->error("Cloud not read input\n");

                die;
            } 

            $msg = trim($msg);
            echo "Client says:\t" . $msg . "\n\n";

            echo "Enter Reply:\t";
            $reply = $this->readline();

            if (!socket_write($this->accept, $reply, strlen($reply))) {
                $this->error("Cloud not write output\n");
            }
        } while (true);

        $this->close();
    }



    private function close () {
        socket_close($this->accept, $this->sock);
    }

    private function readline () 
    {
        return rtrim(fgets(STDIN));
    }

    private function error (String $msg)
    {
        echo $msg . "\n";
        die;
    }
}


