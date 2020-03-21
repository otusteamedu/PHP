<?php
require __DIR__ . '/./vendor/autoload.php';

    if (!isset($_POST['string'])) {
        header('HTTP/1.1 400 Bad Request');
        echo "Everything is VERY BAD";
        exit;
    }
        $validator = new Validator($_POST['string']);
        if ($validator->validate()) {
            header('HTTP/1.1 200 OK');
            echo 'Everything is GOOD';
            exit;
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo "Everything is BAD";
            exit;
        }


