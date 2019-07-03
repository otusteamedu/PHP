<?php

function sendBadCode($message = '')
{
    header("HTTP/1.1 400 Bad Request");
    header("Status: 400 Bad Request");
    echo $message;
}

function sendOkCode($message = '')
{
    header("HTTP/1.1 200 OK");
    header("Status: 200 All ok");
    echo $message;
}
try {

    $pdo = new PDO('mysql:dbname=cinema;host=127.0.0.1', 'testuser', 'testpassword');
} catch (\Exception $e) {
    echo $e->getMessage();
}

exit();