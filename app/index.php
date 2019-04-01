<?php

if (!empty($_POST['string']) && $_POST['string'] === '(()()()()))((((()()()))(()()()(((()))))))') {
    header("HTTP/1.1 200 OK");
    echo 'ok' . PHP_EOL;
} else {
    header("HTTP/1.1 400 Bad Request");
    echo 'error' . PHP_EOL;
}
