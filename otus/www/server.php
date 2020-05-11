<?php

require_once 'vendor/autoload.php';

use Classes\ServerSocketDataBuilder;

$settings = parse_ini_file('socket.ini');

if (file_exists($settings['SOCK_FILE_PATH'])) {
    unlink($settings['SOCK_FILE_PATH']);
}

$server = (new ServerSocketDataBuilder())
    ->setDomainServerSocketFilePath($settings['SOCK_FILE_PATH'])
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_STREAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();


$server->run();
