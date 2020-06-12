<?php
require __DIR__ . '/vendor/autoload.php';

use models\SocketClient;


try {
    $client = new SocketClient('/tmp/hw4.sock');
    $client->run();
} catch (Exception $e) {
    echo $e;
}

exit;