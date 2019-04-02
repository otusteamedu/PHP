#!/usr/local/bin/php

<?php

require_once './vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    die ('I\'m a console app ;)');
}

use HW6_2\SocketGame;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();
declare(ticks=1);

$optCount = null;
$opts = getopt('m:h:p:', ['mode:', 'host:', 'port:'], $optCount);
$posArgs = array_slice($argv, $optCount);

$mode = $opts['mode'] ?? SocketGame::SERVER_MODE;
$address = $opts['host'] ?? SocketGame::DEFAULT_ADDRESS;
$port = $opts['port'] ?? SocketGame::DEFAULT_PORT;
$game = new SocketGame($address, $port);
$closure = function () {
    echo '12112';
//    $game->stopServer();
};
pcntl_signal(SIGTERM, $closure);
pcntl_signal(SIGHUP, $closure);
pcntl_signal(SIGUSR1, $closure);

try {

    if ($mode === SocketGame::SERVER_MODE) {

        $game->runServer();
    } else {
        $number = \count($posArgs) > 0 ? $posArgs[0] : \random_int(1, 10);
        $game->game($number);
    }
} catch (\Throwable $exception) {
    echo \sprintf("%s \n", $exception->getMessage());
}