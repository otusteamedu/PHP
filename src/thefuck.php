<?php

use App\Fuck;

require_once 'vendor/autoload.php';

$fuck = new Fuck(trim($argv[1]));

print $fuck->execute() . PHP_EOL;
