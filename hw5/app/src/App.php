<?php
namespace hw5;

use hw5\Parentheses;

class App
{
    public function run()
    {
        $string = filter_input(INPUT_POST, 'string');
        if (empty($string)) {
            http_response_code(400);
            echo 'empty string';
        } else {
            $pt = new Parentheses($string);
            if ($pt->isValid()) {
                http_response_code(200);
                echo 'OK';
            } else {
                http_response_code(400);
                echo 'incorrect parentheses order';
            }
        }
    }
}