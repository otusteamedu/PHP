<?php

require 'vendor/autoload.php';

use App\Fixer;

while ($line = trim(fgets(STDIN))) {
    $fix = Fixer::fix($line);

    if ($fix) {
        echo $fix . PHP_EOL;
    }
}
