<?php

$client = new SocketClient();
$client->start();

class SocketClient
{
    const SOCKET_LEN = 65536;
    
    public $message = '';
    public $clientFile = '';
    public $serverFile = '';
    
    public function __construct()
    {
        $this->serverFile = dirname(__FILE__) . '/server.sock';
        $this->clientFile = dirname(__FILE__) . '/client.sock';
    }
    
    public function create()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            die($this->getSocketError());
        }
        
        if (!socket_bind($this->socket, $this->clientFile)) {
            $this->stop('socket_bind');
        }
    }
    
    public function start()
    {
        $this->create();
        
        if (!socket_set_nonblock($this->socket)) {
            $this->stop('socket_set_block');
        }
    
        if($msg = readline('message:' . PHP_EOL)) {
            socket_sendto($this->socket, $msg, strlen($msg), 0, $this->serverFile);
        }
        
        if (!socket_set_block($this->socket)) {
            $this->stop('socket_set_nonblock');
        }
        
        if (($len = socket_recvfrom($this->socket, $this->message, self::SOCKET_LEN, 0, $this->serverFile)) == -1) {
            $this->stop('socket_recvfrom');
        }
        
        echo 'You said: ' . $this->message . PHP_EOL;
        
        socket_close($this->socket);
        unlink($this->clientFile);
    }
    
    private function stop($method = '')
    {
        socket_shutdown($this->socket);
        socket_close($this->socket);
        if (file_exists($this->clientFile)) {
            unlink($this->clientFile);
        }
        if($method) {
            die("Socket error ({$method}): " . $this->getSocketError());
        }
    }
    
    public function getSocketError()
    {
        return socket_strerror(socket_last_error()) . PHP_EOL;
    }
    
}