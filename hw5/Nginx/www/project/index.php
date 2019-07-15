<?php
declare(strict_types = 1);

require_once('init.php');

$processor = new RequestsProcessor();

if ($processor->getRequestMethod($_SERVER) != 'POST') {
    exit("Метод не POST");
}
foreach ($_POST as $key => $value) {
    if ($processor->isCorrectParameter($key, $value, $_SERVER)) {

        header("HTTP/1.0 200 OK");
        echo "OK" . PHP_EOL;
    }  else {
            header("HTTP/1.0 400 Bad Request");
            exit("Bad Request" . PHP_EOL);
        }
    
}
