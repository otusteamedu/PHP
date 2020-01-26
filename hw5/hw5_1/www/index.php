<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\StringValidator;

if (empty($_POST['string'])) {
    header('HTTP/1.1 400 Bad Request');
    echo "Bad";
    exit;
}

$bracketValidator = new StringValidator($_POST['string']);
if ($bracketValidator->validate()) {
    header('HTTP/1.1 200 OK');
    echo 'Good';
    exit;
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "Bad";
    exit;
}