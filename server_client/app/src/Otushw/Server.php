<?php

namespace Otushw;

class Server
{

    protected $socketServer;

    public function __construct()
    {
        $this->socketServer = new Socket();
        $this->socketServer->initServer();
    }

    public function run()
    {
        while (true) {
            $socketAccept = $this->socketServer->socketAccept();
            $buf = $this->socketServer->socketRead($socketAccept);
            echo "Received: $buf \n";
            if ($buf === 'exit') {
                break;
            }
            echo "You can answer:";
            $message = $this->socketServer->readSTDIN();
            $this->socketServer->socketWrite($socketAccept, $message);
        }
    }
}
