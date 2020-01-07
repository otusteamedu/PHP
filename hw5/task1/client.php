<?php
require 'vendor/autoload.php';
set_time_limit(0);
$socketFile = __DIR__ . "/server.sock";
try {
    $client = new \Ushakov\Client($socketFile);
    while (strlen($message = readline("Enter your message or leave it blank to close: " . PHP_EOL . "> ")) > 0) {
        $client->sendMessage($message);
        $serverMessage = $client->receiveMessage();
        echo "Server: " . $serverMessage;
    }
    $client->closeConnection();
    echo "Connection was successfully closed" . PHP_EOL;
} catch (\Exception $exception) {
    die($exception->getMessage());
}

