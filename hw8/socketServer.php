<?php

require_once(__DIR__ . '/socketTools.php');

$serverSocket = __DIR__ . "/server.sock";
deleteSocketIfExist($serverSocket);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
validateSocket($socket);

bindSocket($socket, $serverSocket);

while (true) {
    echo "Socket chat" . PHP_EOL;
    setBlock($socket);
    echo "Ready!" . PHP_EOL;
    $response = getData($socket);
    echo strval($response['data']) . PHP_EOL;
    setNonblock($socket);
    $dataToSent = readline("Message: ");
    sentData($socket, $response['socket'], $dataToSent);
}