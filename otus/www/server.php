<?php

require_once 'vendor/autoload.php';

use Classes\ServerSocketDataBuilder;
use Classes\SocketException;
use Classes\SocketServer;

$settings = parse_ini_file('socket.ini');

if (file_exists($settings['SERVER_SOCK_FILE_PATH'])) {
    unlink($settings['SERVER_SOCK_FILE_PATH']);
}

$server = (new ServerSocketDataBuilder())
    ->setDomainServerSocketFilePath($settings['SERVER_SOCK_FILE_PATH'])
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_STREAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();


$server->run();


if (isset($serverSocket)) {
    $server->socketClose($serverSocket);
    echo 'Сокет успешно закрыт';
}
