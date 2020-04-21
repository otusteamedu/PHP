<?php

require_once 'vendor/autoload.php';

use Classes\ClientSocketDataBuilder;
use Classes\SocketException;

header('Content-Type: text/plain;');
set_time_limit(0);
ob_implicit_flush();

$client = (new ClientSocketDataBuilder())
    ->setDomainServerSocketFilePath(__DIR__. '/server.sock')
    ->setDomainClientSocketFilePath(__DIR__. '/app.sock')
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_DGRAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();

try {
    $socket = $client->socketCreate();
} catch(Throwable $e){
    echo $e->getMessage();
}

try {
    $res = $client->socketBind($socket);
    echo "Сокет успешно связан с адресом и портом\n";
} catch (Throwable $e) {
    echo $e->getMessage();
}

do {
    sleep(2);
    $out = $client->read($socket);
    echo "Сообщение от сервера: $out.\n";
    $msg = 'Принято';
    $client->write($socket, $msg);
} while(true);


if (isset($socket)) {
    $client->socketClose($socket);
    echo 'Сокет успешно закрыт';
}
