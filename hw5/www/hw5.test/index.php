<?php 

require 'vendor/autoload.php';

use Nlazarev\Hw5\Model\Brackets\BracketsValidator;

if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") {
    if (!empty($_POST["string"])) {
        $brackets_string = $_POST["string"];
    }

}

#$brackets_string = "(()))(";

$brackets = new BracketsValidator($brackets_string);

if ($brackets->validateString()) {
    echo http_response_code(200) . " OK";
#    echo "$brackets_string correct";
} else {
    echo http_response_code(400) . " Bad Request";
#    echo "$brackets_string incorrect";
}