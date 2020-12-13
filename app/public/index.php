<?php

require_once '../vendor/autoload.php';

use EmailValidator\EmailValidator;

try {
    $app = new EmailValidator();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}