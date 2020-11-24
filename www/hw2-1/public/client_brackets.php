<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Nlazarev\Hw2_1\AppClientBrackets;

try {
    AppClientBrackets::run();
} catch (Exception $e) {
    echo $e->getMessage();
}