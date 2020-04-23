<?php

require_once 'vendor/autoload.php';

use Classes\ClientSocketDataBuilder;

$settings = parse_ini_file('socket.ini');

$client = (new ClientSocketDataBuilder())
    ->setDomainServerSocketFilePath($settings['SOCK_FILE_PATH'])
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_STREAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();

$client->run();
