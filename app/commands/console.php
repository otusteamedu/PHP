<?php

require_once '../bootstrap/bootstrap.php';

use Commands\ConsoleCommand;
use Otus\Logger\AppLogger;
use Otus\View\View;

try {
    $console = new ConsoleCommand($argv);
    $console->run();
}catch (Exception $e) {
    View::showMessage($e->getMessage());
    AppLogger::addLog(\Monolog\Logger::ERROR, $e->getMessage());
}