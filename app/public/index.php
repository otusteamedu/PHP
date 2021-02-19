<?php

require_once '../bootstrap/bootstrap.php';

use EmailValidator\EmailValidator;

try {
    $app = new EmailValidator();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}