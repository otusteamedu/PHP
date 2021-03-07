<?php
// берем данные из файла настроек
require_once __DIR__ . '/../bootstrap/init.php';

try {
    $client = new Sockets\clientSocket(
        $_ENV['CLIENT_SOCKET_HOST'],
        $_ENV['CLIENT_SOCKET_PATH'],
        $_ENV['CLIENT_SOCKET_PORT'],
        $_ENV['CLIENT_SOCKET_DOMAIN'],
    );
    $client->start();
} catch (\Exception $exception) {
    echo "Error:". $exception->getCode().". ".$exception->getMessage().PHP_EOL;
}

echo "Good bye. See you later...\n";