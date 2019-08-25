<?php

require_once(__DIR__ . '/socketTools.php');

$clientSocket = __DIR__ . "/client.sock";
$serverSocket = __DIR__ . "/server.sock";

deleteSocketIfExist($clientSocket);

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
validateSocket($socket);

bindSocket($socket, $clientSocket);
setNonblock($socket);

$dataToSent = readline('Message: ');
sentData($socket, $serverSocket, $dataToSent);

setBlock($socket);

$response = getData($socket);

echo strval($response['data']) . PHP_EOL;

socket_close($socket);
unlink($clientSocket);
echo "Bye!";