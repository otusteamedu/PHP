<?php

namespace Socket;

use Client\Client;
use Server\Server;

class Socket
{
    public function run($argv = [])
    {
        if (php_sapi_name() != 'cli') {
            throw new Exception('run it in cli');
        }

        if (!empty($argv[1]) and $argv[1] == 'server') {
            Server::start();
        }

        if (!empty($argv[1]) and $argv[1] == 'client') {
            Client::start();
        }
    }
}
