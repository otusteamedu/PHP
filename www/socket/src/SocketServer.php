<?php

$server = new SocketServer();
$server->start();

class SocketServer
{
    const SOCKET_LEN = 65536;
    
    public $message = '';
    public $clientFile = '';
    public $serverFile = '';
    
    public function __construct()
    {
        $this->serverFile = dirname(__FILE__) . '/server.sock';
    }
    
    public function create()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            die($this->getSocketError());
        }
        
        if (!socket_bind($this->socket, $this->serverFile)) {
            $this->stop('socket_bind');
        }
    }
    
    public function start()
    {
        $this->create();
        
        while(true) {
            
            if (!socket_set_block($this->socket)) {
                $this->stop('socket_set_block');
            }

            
            if (($len = socket_recvfrom($this->socket, $this->message, self::SOCKET_LEN, 0, $this->clientFile)) == -1) {
                $this->stop('socket_recvfrom');
            }

            echo 'Client message: ' . $this->message . PHP_EOL;
            
            if (!socket_set_nonblock($this->socket)) {
                $this->stop('socket_set_nonblock');
            }

            socket_sendto($this->socket, $this->message, strlen($this->message), 0, $this->clientFile);
        }
    }
    
    private function stop($method = '')
    {
        socket_shutdown($this->socket);
        socket_close($this->socket);
        if (file_exists($this->serverFile)) {
            unlink($this->serverFile);
        }
        die("Socket error ({$method}): " . $this->getSocketError());
    }
    
    public function getSocketError()
    {
        return socket_strerror(socket_last_error()) . PHP_EOL;
    }
    
}