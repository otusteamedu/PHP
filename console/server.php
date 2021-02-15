<?php


use App\Server;
use App\Socket\Exceptions\SocketException;

require __DIR__ . '/../vendor/autoload.php';

$socketFile = $_ENV['SOCKET_DIR'] . '/' . $_ENV['SOCKET_FILE'];

try {
    $server = new Server($socketFile);

    $server->listen();

    $server = null;

} catch (SocketException $e) {
    echo 'Socket exception', PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
}
