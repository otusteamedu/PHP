<?php

require_once 'vendor/autoload.php';

use Classes\ClientSocketDataBuilder;
use Classes\SocketException;

$settings = parse_ini_file('socket.ini');

$client = (new ClientSocketDataBuilder())
    ->setDomainServerSocketFilePath($settings['SERVER_SOCK_FILE_PATH'])
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_STREAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();

$client->run();

if (isset($socket)) {
    $client->socketClose($socket);
    echo 'Сокет успешно закрыт';
}
