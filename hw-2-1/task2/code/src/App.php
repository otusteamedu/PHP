<?php

namespace App;

use Repetitor202\Env;
use Repetitor202\Server;
use Repetitor202\Client;

class App
{
    public function run()
    {
        Env::init();
        $argv1 = $_SERVER['argv'][1];

        if($argv1 == 'server') {
            $server = new Server();
            $server->listen();
        } elseif ($argv1 == 'client') {
            $client = new Client();
            $client->sendData();
        } else {
            throw new \Exception('available values for first arg: server, client' . PHP_EOL);
        }
    }
}