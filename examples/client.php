#!/usr/bin/env php
<?php

use crazydope\socket\SocketFactory;

require '../vendor/autoload.php';

$address = 'tcp://127.0.0.1:1337';

$client = (new SocketFactory(SocketFactory::CLIENT))->createFromString($address);
echo "Client connected to: $address \n";

$message = 'Hello Server';
echo "Message to server: $message \n";

$client->write($message);
$reply = $client->read(9);

echo "Reply from server: $reply \n";
$client->close();

