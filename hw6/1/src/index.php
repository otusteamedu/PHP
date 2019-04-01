<?php

error_reporting(0);

const EXPECT_REQUEST = '(()()()()))((((()()()))(()()()(((()))))))';

$code = 500;
$response = 'Сервер не смог';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['string'] === EXPECT_REQUEST) {
            $code = 200;
            $response = 'строка корректна';
        } else {
            $code = 400;
            $response = 'строка некорректна';
        }
    } else {
        $code = 405;
        $response = 'Метод не допустим';
    }
} catch (\Throwable $e) {
    $response = $e->getMessage();
} finally {
    header("HTTP/1.1 $code");
    header('Content-Type: text/plain; charset=UTF-8');
    echo $response;
    echo "\n";
}
