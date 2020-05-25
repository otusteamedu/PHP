<?php
declare(strict_types=1);

require "vendor/autoload.php";

$client = new \HW4\Client(
    new \HW4\Config\Config('config.ini'),
    new \HW4\Socket\SocketService()
);

try {
    echo '> ' . $client->request('PING') . PHP_EOL;
    echo '> ' . $client->request('Another message') . PHP_EOL;
} catch(\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}