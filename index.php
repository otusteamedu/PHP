<?php

use APankov\Fuck;

require_once 'vendor/autoload.php';

if ($command = trim($argv[1])) {
    $fuck = new Fuck($command);
    print $fuck->execute() . PHP_EOL;
}
