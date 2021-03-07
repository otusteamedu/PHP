<?php
use \Sockets\serverSocket;
// берем данные из файла настроек
require_once __DIR__ . '/../bootstrap/init.php';

try {
    $createdObject = ($_ENV['SERVER_SOCKET_MULTICONNECTION'] == 'true') ? 'Sockets\serverConnections' : 'Sockets\serverSocket';
    $server = new $createdObject(
        $_ENV['SERVER_SOCKET_HOST'],
        $_ENV['SERVER_SOCKET_PATH'],
        $_ENV['SERVER_SOCKET_PORT'],
        $_ENV['SERVER_SOCKET_DOMAIN'],
        $_ENV['SERVER_SOCKET_MAX_CONNECTIONS'],
        $_ENV['SERVER_SOCKET_BUFFER_LENGTH'],
    );
    $server->start();
} catch (\Exception $exception) {
    echo "Error:". $exception->getCode().". ".$exception->getMessage().PHP_EOL;
}

echo "Good bye. See you later...\n";

