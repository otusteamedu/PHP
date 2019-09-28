<?php
require_once('vendor/autoload.php');

use EvilWolf\RoundBracketsValidator;

$header = 'HTTP/1.1 400 Bad Request';
$message = 'Brackets invalid';

if (!empty($_POST['string'])) {
    $validator = new RoundBracketsValidator($_POST['string']);

    if ($validator->isValid()) {
        $header = 'HTTP/1.1 200 OK';
        $message = 'Brackets valid!';
    }
}

header($header);
echo $message;
