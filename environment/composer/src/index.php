<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Otus\Kernel;

$kernel = new Kernel();

echo $kernel->hello() . "\n";