<?php
require_once(__DIR__ . '/common.php');

$server = __DIR__ . "/server.sock";
deleteSocketIfExist($server);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
validateSocket($socket);
bindSocket($socket, $server);

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