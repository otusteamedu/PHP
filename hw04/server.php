#!/usr/bin/php -q
<?php

use App\Socket\UnixSocket;

require __DIR__ . '/vendor/autoload.php';

set_time_limit(0);

echo "\e[36mSocket Receiver\e[39m\n";

try {
    $socket = new UnixSocket();

    $socket->bind(__DIR__ . '/var/server.sock');

    $messageCount = 0;

    while (1) {
        $socket->setBlock();

        if ($messageCount === 0) {
            echo "Waiting for messages...\n";
        }

        $message = $socket->receive();

        $messageCount++;

        echo "{$messageCount}. Message from sender: {$message->content}\n";

        $socket->setNonBlock();

        $sentBytes = $socket->send("Message \"{$message->content}\" received", $message->from);
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}\n";
} finally {
    $socket->close();
}
