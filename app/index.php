<?php

require_once 'vendor/autoload.php';

// Если не POST-запрос или отсутствует $_POST['string'], возвращаем 400 Bad Request
if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['string'])) {
    http_response_code(400);
    exit;
}

$validator = new \App\Validator($_POST['string']);

// Если строка невалидна возвращаем код 400 Bad Request, если валидна - 200 OK
if ($validator->execute()) {
    http_response_code(200);
} else {
    http_response_code(400);
}

