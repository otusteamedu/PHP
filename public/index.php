<?php
declare(strict_types=1);

use Socket\Ruvik\App;
use Socket\Ruvik\Factory\InputArgsFactory;
use Socket\Ruvik\Service\IniManager;
use Socket\Ruvik\Service\Router;

require_once 'config.php';

$inputArgsFactory = new InputArgsFactory();
echo 'test2';
$iniManager = new IniManager();
echo 'test3';
$router = new Router($iniManager);
echo 'test4';
dump(['$argv' => $argv]);
$app = new App($inputArgsFactory, $router);
$app->run($argv);


die();
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);//создаём сокет
if (false === $socket) {
    throw new \Socket\Ruvik\Exception\RuntimeException('Can\'t create socket.' . socket_strerror(socket_last_error($socket)));
}

socket_bind($socket, $configIni['socket_connection']['ip'], 8000);//привязываем его к указанным ip и порту
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);//разрешаем использовать один порт для нескольких соединений

if (false === socket_listen($socket)) {
    throw new \Socket\Ruvik\Exception\RuntimeException('Can\'t create socket.' . socket_strerror(socket_last_error($socket)));
}

while ($connect = socket_accept($socket)) {
    fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nПривет");
    fclose($connect);
}
