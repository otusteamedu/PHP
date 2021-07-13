<?php

namespace App;

class Server
{
    private $socket;
    private array $config;

    public function __construct()
    {
        $this->config = Config::getConfig();

        if (file_exists($this->config['socket_path'])){
            unlink($this->config['socket_path']);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    }

    /**
     * @throws AppException
     */
    public function start(): void
    {
        if ($this->socket === false) {
            throw new AppException('Unable to create AF_UNIX socket');
        }

        $serverSideSock = $this->config['socket_path'];

        $this->print( $serverSideSock);

        if (!socket_bind($this->socket, $serverSideSock)) {
            throw new AppException("Unable to bind to $serverSideSock");
        }

        while(true)
        {
            $this->listen();
        }
    }

    /**
     * @throws AppException
     */
    private function listen(): void
    {
        if (!socket_set_block($this->socket)){
            throw new AppException('Unable to set blocking mode for socket');
        }

        $buf = '';
        $this->print( "Ready to receive...");

        $bytesReceived = socket_recvfrom($this->socket, $buf, 65536, 0, $from);

        if ($bytesReceived === -1){
            throw new AppException('An error occured while receiving from the socket');
        }

        $this->print("Received $buf client");
    }


    private function print(string $message): void
    {
        echo $message . PHP_EOL;
    }

}