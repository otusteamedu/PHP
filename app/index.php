<?php

require_once ('BracketsValidator.php');

if (empty($_POST['string'])) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

$bracketValidator = new BracketsValidator($_POST['string']);
if ($bracketValidator->validate()) {
    header('HTTP/1.1 200 OK');
    exit;
} else {
    header('HTTP/1.1 400 Bad Request');
    exit;
}