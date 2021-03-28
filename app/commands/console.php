<?php

require_once '../bootstrap/bootstrap.php';

use Commands\ConsoleCommand;
use Otus\View\View;

try {
    $console = new ConsoleCommand($argv);
    $console->run();
}catch (Exception $e) {
    View::showMessage($e->getMessage());
}