<?php

use APankov\BracketsChecker as Checker;

require_once "vendor/autoload.php";

if (Checker::checkRequest()) {
    header('HTTP/1.1 200 OK');
    echo "OK";
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "Bad Request";
}


