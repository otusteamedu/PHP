<?php


namespace app;

use App\Config;
use App\Server;
use App\Client;

class App
{
    public function __construct()
    {
        Config::get(); // get environment variables
    }

    public function run()
    {
        $arg = $_SERVER['argv'][1];

        if ($arg == 'server') {
            $server = new Server();
            $server->listeningSocket();
        }
        
        if ($arg == 'client') {
            $client = new Client();
            $client->useSocket();
            $client->sentData();
        }
    }
}