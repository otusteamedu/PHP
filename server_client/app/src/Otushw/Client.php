<?php

namespace Otushw;

class Client
{
    protected $socketClient;

    public function __construct()
    {
        $this->socketClient = new Socket();
        $this->socketClient->initClient();
    }

    public function run()
    {
        echo 'Enter Message:';
        $message = $this->socketClient->readSTDIN();
        $socket = $this->socketClient->getSocket();
        $this->socketClient->socketWrite($socket, $message);
        $buf = $this->socketClient->socketRead($socket);
        echo "Server answer:" . $buf ;
    }
}