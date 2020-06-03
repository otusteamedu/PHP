<?php
if (php_sapi_name() !== 'cli') {
    throw new Exception('Access denied');
}

require_once __DIR__.'/../vendor/autoload.php';

use Noodlehaus\Config;
use Socket\Raw\Factory;

$config = new Config(__DIR__.'/../config/client.ini');
if (($address = $config->get('socket')) === null) {
    throw new Exception('Property "socket" is not set in config');
}

$shortopts = 'u:p:d::t';

$longopts = [
    "user:",
    "password:",
    "database::",
    "test"
];

$command = $argv[1] ?? null;
$parameters = $argv[2] ?? null;

$factory = new Factory();

// connect to local Unix stream socket path
$socket = $factory->createClient($address);
$result = $socket->read(2048);
if ($result == 'Hello') {
    echo "Connected ".$socket->getPeerName().PHP_EOL;
    $socket->write(implode(' ', array_filter([$command, $parameters])));
    $result = $socket->read(2048);
    var_dump($result);
} else {
    echo "Unknown server response {$result}".PHP_EOL;
}
$socket->close();
