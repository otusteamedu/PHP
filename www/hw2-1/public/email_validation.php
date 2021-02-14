<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Nlazarev\Hw2_1\AppEmailValidation;

try {
    AppEmailValidation::run();
} catch (Exception $e) {
}
