<?php

namespace UnixSockets;

abstract class Socket
{
    protected $socket;
    protected $errors = [];
    protected $pathToSocket;
    protected $messageLength;
    protected $config;
    protected $message;

    abstract protected function Act();
    
    public function __construct($server = true, $message = '')
    {
        $this->message = $message;
        $this->config = require_once __DIR__ . '/../app/config.php';
        $this->server = $server;
        $this->pathToSocket = ($server ? $this->config['server_socket_file_path'] :  $this->config['client_socket_file_path']);
        $this->messageLength =  $this->config['message_length'];
        
        $this->deleteSocketFile();

        if ($this->connect()) {
            $this->Act();
        } else {
            foreach ($this->errors as $error) {
                echo $error . PHP_EOL;
            }
        }
    }

    protected function connect()
    {
        try {
            if (!extension_loaded('sockets')) {
                throw new \Exception('The sockets extension is not loaded.');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }

        try {
            if (!$this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)) {
                throw new \Exception('Unable to create AF_UNIX socket');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }

        try {
            if (!socket_bind($this->socket, $this->pathToSocket)) {
                throw new \Exception("Unable to bind to $this->pathToSocket");
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }
        return ($this->errors) ? false : true;
    }

    protected function sendData($socketPath, $len, $message = '')
    {
        try {
            if (!socket_set_nonblock($this->socket)) {
                throw new \Exception('Unable to set nonblocking mode for socket');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }
        
        $msg = ($this->server) ? $message : $this->message;
        $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $socketPath);
        try {
            if ($bytes_sent == -1) {
                throw new \Exception('An error occured while sending to the socket');
            } elseif ($bytes_sent != $len) {
                throw new \Exception($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }
    }

    protected function receiveData()
    {
        try {
            if (!socket_set_block($this->socket)) {
                throw new \Exception('Unable to set blocking mode for socket');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }

        $buf = '';
        $from = '';
        echo ($this->server) ? "Ready to receive" . PHP_EOL : "";

        // will block to wait server response
        $bytes_received = socket_recvfrom($this->socket, $buf, $this->messageLength, 0, $from);
        try {
            if ($bytes_received == -1) {
                throw new \Exception('An error occured while receiving from the socket');
            }
        } catch (\Exception $e) {
            $this->collectErrors($e);
        }

        echo ($this->server) ? "Received $buf from $from\n" : "socket $from received your message: $buf";

        return ['sender' => $from, 'message' => $buf];
    }
    
    protected function collectErrors($e)
    {
        $this->errors[] =  $e->getMessage();
    }
    
    protected function echoErrors()
    {
        foreach ($this->errors as $error) {
            echo $error . PHP_EOL;
        }
    }

    protected function deleteSocketFile()
    {
        if (file_exists($this->pathToSocket)) {
            unlink($this->pathToSocket);
        }
    }

    public function __destruct()
    {
        $this->deleteSocketFile();
        
        if ($this->errors) {
            $this->echoErrors();
        }
        echo ($this->server) ? 'Server stopped' : PHP_EOL . 'Run client to send new message' . PHP_EOL;
    }
}
