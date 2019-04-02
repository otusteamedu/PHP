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

global $game;
function sig_handler(int $signo)
{
    global $game;
    switch ($signo) {
        case SIGTERM:
        case SIGHUP:
        case SIGUSR1:
        default;
            $game->stopServer();
            break;
    }
}

pcntl_async_signals(true);
if (!pcntl_signal(SIGTERM, 'sig_handler')) {
    echo \sprintf("Unable to set sig handler %d \n", SIGTERM);
    exit;
}
if (!pcntl_signal(SIGHUP, 'sig_handler')) {
    echo \sprintf("Unable to set sig handler %d \n", SIGHUP);
    exit;
}
if (!pcntl_signal(SIGUSR1, 'sig_handler')) {
    echo \sprintf("Unable to set sig handler %d \n", SIGUSR1);
    exit;
}

$optCount = null;
$opts = getopt('m:h:p:', ['mode:', 'host:', 'port:'], $optCount);
$posArgs = array_slice($argv, $optCount);

$mode = $opts['mode'] ?? SocketGame::SERVER_MODE;
$address = $opts['host'] ?? SocketGame::DEFAULT_ADDRESS;
$port = $opts['port'] ?? SocketGame::DEFAULT_PORT;

try {
    $game = new SocketGame($address, $port);
    if ($mode === SocketGame::SERVER_MODE) {
        $game->runServer();
    } else {
        $number = \count($posArgs) > 0 ? $posArgs[0] : \random_int(1, 10);
        $game->game($number);
    }
} catch (\Throwable $exception) {
    echo \sprintf("%s \n", $exception->getMessage());
}
