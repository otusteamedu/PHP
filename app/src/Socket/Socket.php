<?php

namespace Socket;

// require_once('/var/www/hw-otus/src/Socket/Types/Server.php'); 
// require_once(__DIR__.'/Types/Client.php'); 
use Types\Server;
use Types\Client;

class Socket {

    public function run($argv = []) 
    {
        if (php_sapi_name() != 'cli') {
            throw new Exception('run it in cli', 500);
        }
        
        if (!empty($argv[1]) and $argv[1] == 'server') {
            $server = new Server();
            $server->start();
        }
        
        if (!empty($argv[1]) and $argv[1] == 'client') {
            $client = new Client();
            $client->start();
        }
    }

}
