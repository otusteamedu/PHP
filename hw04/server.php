#!/usr/bin/php -q
<?php

use App\IO\Output\StdOutput;
use App\Socket\Server;

require __DIR__ . '/vendor/autoload.php';

set_time_limit(0);

$output = new StdOutput();

$output->info("Socket Receiver");

try {
    $server = new Server($output, __DIR__ . '/var/server.sock');
    $server->run();
} catch (Exception $e) {
    $output->error("Error: {$e->getMessage()}\n");
} finally {
    $server->exit();
}
