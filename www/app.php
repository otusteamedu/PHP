<?php

use Dotenv\Dotenv;

include_once __DIR__ . '/vendor/autoload.php';

try{
    set_time_limit(0);

    $env = Dotenv::createImmutable(dirname(__FILE__));
    $env->load();

    $option = $argv[1];

    switch ($option) {
        case 'server':
            $server = new Classes\Socket(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));        
            $server->listen();
            
            break;
        
        case 'client':
            $client = new Classes\Client(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));        

            $msg = fgets(STDIN);

            if (!empty($msg)) {
                echo $client->send($msg);
                echo $client->response() . "\n";
            } 

            break;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
