<?php
require_once ('vendor/autoload.php');

use Src\Validator;

try {
    $string = $_POST['string'] ?? null;

    if ($string) {
        $validator = new Validator($string);

        if ($validator->validateBrackets()) {
            header("HTTP/1.0 200 Ok");
            echo 'Все ок' . PHP_EOL;
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo 'Все плохо' . PHP_EOL;
        }

    } else {
        echo 'string is not set.' . PHP_EOL;
    }
} catch (RuntimeException $e) {
    echo $e->getMessage();
}