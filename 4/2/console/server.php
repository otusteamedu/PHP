<?php
require '../vendor/autoload.php';

use Otus\Sockets\Server;

try {
	$sock = dirname(__FILE__) . "/client.sock";
	$server = new Server($sock);
	$server->listen();
} catch (Exception $e) {
	echo 'SocketsException ' . $e->getMessage() . PHP_EOL;
}
