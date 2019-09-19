#!/usr/bin/php -q
<?php

use App\Socket\UnixSocket;

require __DIR__ . '/vendor/autoload.php';

set_time_limit(0);

echo "\e[36mSocket Sender\e[39m\n";

try {
    $socket = new UnixSocket();

    $socket->bind(__DIR__ . '/var/client.sock');

    $continue = true;

    while ($continue) {
        $line = trim(readline('Your message ("quit" for exit): '));

        if ($line === 'quit') {
            $continue = false;
            continue;
        }

        $socket->setNonBlock();
        $socket->send($line, __DIR__ . '/var/server.sock');
        $socket->setBlock();

        $message = $socket->receive();
        echo "Message from receiver: {$message->content}\n";
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}\n";
} finally {
    $socket->close();
}
