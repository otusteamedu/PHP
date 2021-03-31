<?php

require_once '../bootstrap/bootstrap.php';

use Commands\ConsoleCommand;
use Monolog\Logger;
use Otus\Exceptions\AppException;
use Otus\Logger\AppLogger;
use Otus\Message\Message;

try {
    $console = new ConsoleCommand($argv);
    $console->run();
} catch (AppException $exception) {
    Message::showMessage($exception->getMessage());
} catch (Exception $e) {
    Message::showMessage($e->getMessage());
    AppLogger::addLog(Logger::CRITICAL, $e->getMessage());
}