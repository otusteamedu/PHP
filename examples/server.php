#!/usr/bin/env php
<?php

use \crazydope\socket\SocketFactory;

require '../vendor/autoload.php';

$address = 'tcp://127.0.0.1:1337';

$server = (new SocketFactory())->createServer($address);
echo "Server address: $address \n";

while (true) {
    if ($client = $server->accept()) {
        $msg = trim($client->read(12));
        echo "Client Message : $msg \n";
        $client->write('Accepted!');
        $client->close();
    }
}

