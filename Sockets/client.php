<?php
require_once(__DIR__ . '/common.php');

$client = __DIR__ . "/client.sock";
$server = __DIR__ . "/server.sock";

deleteSocketIfExist($client);
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
validateSocket($socket);
bindSocket($socket, $client);
setNonblock($socket);
$dataToSent = readline('Message: ');
sentData($socket, $server, $dataToSent);
setBlock($socket);
$response = getData($socket);
echo strval($response['data']) . PHP_EOL;
socket_close($socket);
unlink($client);
echo "Bye!";
