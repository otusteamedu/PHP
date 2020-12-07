<?php
require '../vendor/autoload.php';

use Otus\Sockets\Client;

try {
	$sock = dirname(__FILE__) . "/client.sock";
	$client = new Client($sock);
	$client->waitForMessage();
} catch (Exception $e) {
	echo 'Can not connect to server. ' . $e->getMessage() . PHP_EOL;
}
