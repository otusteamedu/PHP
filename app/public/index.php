<?php

require_once '../vendor/autoload.php';

use EmailValidator\EmailValidator;

try {
    $app = new EmailValidator();
    $app->run($_POST);
} catch (Exception $e) {
    echo $e->getMessage();
}