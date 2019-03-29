<?php

require 'vendor/autoload.php';

use App\Fixer;

$fixer = new Fixer();

while ($line = trim(fgets(STDIN))) {
    $fix = $fixer->fix($line);

    if ($fix) {
        echo $fix . PHP_EOL;
    }
}
