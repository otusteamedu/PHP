<?php

require_once 'app.php';

use function Otus\validateBrackets;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['string']) && validateBrackets($_POST['string'])) {
    header('HTTP/1.1 200 OK');
} else {
    header('HTTP/1.1 400 Bad Request');
}