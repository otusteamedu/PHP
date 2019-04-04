<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['string'])) {
        if ($_POST['string'] === '(()()()()))((((()()()))(()()()(((()))))))') {
            $code = 200;
            $response = 'String is valid';
        } else {
            $code = 400;
            $response = 'String is invalid';
        }
    } else {
        $code = 400;
        $response = 'String is required';
    }
} else {
    $code = 405;
    $response = 'Method not allowed';
}
header("HTTP/1.1 $code");
header('Content-Type: text/plain; charset=UTF-8');
echo $response;
echo "\n";
