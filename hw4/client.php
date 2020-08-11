<?php

require 'vendor/autoload.php';

use Noodlehaus\Config;
use nlazarev\hw4\Model\Sockets\ClientUnixSocket;

$conf = new Config('config/socket_client.json');

$path_to_socket = dirname(__FILE__). $conf->get('app.path_to_socket');
$connect_attempts = $conf->get('app.connect_attempts');
$connect_timeout = $conf->get('app.connect_timeout');
$client_exit_string = $conf->get('app.client_exit_string');

$socket = new ClientUnixSocket();

if ($socket->isSocketOk()) {
    $connect_attempt = 0;
    
    while (!($connected = $socket->connect($path_to_socket))
     && $connect_attempt++ < $connect_attempts) {
        echo "Attempt to connect $attempt \n";
        sleep($connect_timeout);
    }

    if ($connected) {
        echo "Connected to $path_to_socket - Done \n";
        echo "Type a message for send to the server [Enter] \n";
        echo "for exit, type '$client_exit_string' \n";
        $stdin = fopen("php://stdin", "r");
    } else {
        echo $socket->getErrorMsg() . PHP_EOL;
    }
        
    while ($connected) {
        echo "Message: ";
        $msg = fgets($stdin);
            
        if ($msg == $client_exit_string . PHP_EOL) {
            fclose($stdin);
            socket_close($socket->getInstance()); 
            $connected = false;
        } else {
            if (!$socket->sendMsg($msg)) {
                echo $socket->getErrorMsg() . PHP_EOL;
                $connected = false;
            }               
        }
            
        if (is_null($msg2 = $socket->readMsg())) {
            echo $socket->getErrorMsg() . PHP_EOL;
        } else {
            echo $msg2 . PHP_EOL;
        }               
    }
               
} else {
    echo $socket->getErrorMsg() . PHP_EOL;
}
