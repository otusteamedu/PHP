<?php

require '../vendor/autoload.php';

use Validators\BracketsValidator;

$string = $_POST['string'] ?? '';

try {
    (new BracketsValidator($string))->validate();
} catch (Exception $e) {

}