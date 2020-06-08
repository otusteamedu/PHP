<?php

namespace Classes;

class Driver {
    public function run (String $option) {
        switch ($option) {
            case 'server':
                $this->server();            
                break;
            
            case 'client':
                $this->client();
                break;
        }
    }

    private function server () {
        $server = new \Classes\Socket(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));        
        $server->listen();
    }

    private function client () {
        $client = new \Classes\Client(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));        

        $msg = fgets(STDIN);

        if (!empty($msg)) {
            echo $client->send($msg);
            echo $client->response() . "\n";
        } 
    }
}
