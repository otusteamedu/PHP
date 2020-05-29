<?php

require '../vendor/autoload.php';

try {
    $bracketsChecker = new \HW5\BracketsChecker();
    $bracketsChecker->run();
} catch (Exception $error) {
    echo $error->getMessage();
}