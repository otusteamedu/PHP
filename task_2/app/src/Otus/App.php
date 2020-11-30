<?php

namespace Otus;

use Otus\socket\SocketServer;
use Otus\socket\SocketClient;

class App
{
    private $argvFirst = '';

    function __construct()
    {
        if (isset($_SERVER['argv'][1])) $this->argvFirst = $_SERVER['argv'][1];
    }

    public function run()
    {
        switch ($this->argvFirst) {
            case 'server':
                $server = new SocketServer();
                $server->run();
                break;
            case 'client':
                $client = new SocketClient();
                $client->run();
                break;
            default:
                echo 'Type "server" or "client" params!';
        }
    }
}