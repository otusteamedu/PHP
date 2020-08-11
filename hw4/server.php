<?php

require 'vendor/autoload.php';

use Noodlehaus\Config;
use nlazarev\hw4\Model\Sockets\ServerUnixSocket;

$conf = new Config('config/socket_server.json');

$path_to_socket = dirname(__FILE__). $conf->get('app.path_to_socket');
$max_clients_connections = $conf->get('app.max_clients_connections');

$socket = new ServerUnixSocket($path_to_socket);

if ($socket->isSocketOk()) {
    echo "Waiting for clients connections.. \n";

    $clients_count = 0;
    
    while (true) {
#        sleep(5);
        if (!$socket->processClientsConnections($max_clients_connections)) {
            echo $socket->getErrorMsg() . PHP_EOL;            
        }

        if ($clients_count != $socket->getClientsCount()) {
            $clients_count = $socket->getClientsCount();
            echo "Total active connections: $clients_count \n";
        }
    }   

} else {
    echo $socket->getErrorMsg() . PHP_EOL;
}


