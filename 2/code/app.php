<?php
require_once 'bootstrap/app.php';

use Src\Sockets\Exceptions\InvalidArgumentsException;
use \Src\Sockets\Client;
use \Src\Sockets\Server;

try {
    $role = (isset($argv[1])) ? $argv[1] : null;
    if (!empty($role)) {
        if ($role == 'client') {
            $app = new Client(
                $_ENV['SOCKET_PATH'],
                $_ENV['SOCKET_PORT']);
            $app->waitForMessage();
        } else {
            $app = new Server(
                $_ENV['SOCKET_PATH'],
                $_ENV['SOCKET_PORT']
            );
            $app->listen();
        };
    } else {
        throw new InvalidArgumentsException('Socket role must be set.' . PHP_EOL);
    }
} catch (InvalidArgumentsException $e) {
    header("HTTP/1.0 400 Bad Request");
    echo $e->getMessage();
}