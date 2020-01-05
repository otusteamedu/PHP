<?php

require("Client.php");

$client = new Client("config.ini");

try {
    $line = trim(fgets(STDIN));
    if($client == false) throw new Exception("Can't create client socket");
    $client->start($line);
} catch (Exception $e) {
    echo $e->getMessage();
}



