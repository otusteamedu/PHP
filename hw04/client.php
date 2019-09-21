#!/usr/bin/php -q
<?php

use App\IO\Input\StdInput;
use App\IO\Output\StdOutput;
use App\Socket\Client;

require __DIR__ . '/vendor/autoload.php';

set_time_limit(0);

$input = new StdInput();
$output = new StdOutput();

$output->writeLn('Soket Sender');

try {
    $client = new Client($input, $output, __DIR__ . '/var/client.sock');
    $client->run(__DIR__ . '/var/server.sock');
} catch (Exception $e) {
    $output->error("Error: {$e->getMessage()}");
} finally {
    $client->exit();
}
