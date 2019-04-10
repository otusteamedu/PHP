<?php

if (!empty($_POST['string']) && $_POST['string'] === '(()()()()))((((()()()))(()()()(((()))))))') {
    header("HTTP/1.1 200 OK");
    exit("ok");
}

header("HTTP/1.1 400 Bad Request");
exit("error");