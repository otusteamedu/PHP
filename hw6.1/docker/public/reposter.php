<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Brackets;

$str = $_POST['string'];

if (!empty($str) && strlen($str) > 0) {
    $brackets = new Brackets();
    if ($brackets->matchBrackets($str) === true) {
        http_response_code(200);
        exit(0);
    }
}

http_response_code(400);

