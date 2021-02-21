<?php


namespace Src;


class Printer
{
    public static function printResult($result) {
        if (!empty($result)) {
            echo 'Validated emails list: ' . PHP_EOL;
            foreach ($result as $email) {
                echo $email;
            }
        } else {
            echo 'No valid email found';
        }
    }
}