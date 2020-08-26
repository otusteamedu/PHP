<?php


namespace App;

use Exception;

class Validator
{
    public function __construct()
    {
        try {
            if (empty($_SERVER["CONTENT_LENGTH"])) {
                 throw new Exception("Content-Length is empty.");
            }
            if (empty($_POST)) {
                throw new Exception("data should be sent by post");
            }

            if (empty($_POST[key($_POST)])) {
                throw new Exception("empty value");
            }

            $this->validate((string)$_POST[key($_POST)]);

        } catch (Exception $exception) {
            header('400 Bad Request ' . $exception->getMessage(), false, 400);
        }
    }

    private function validate(string $string)
    {
        if (strlen($string) % 2 !== 0) {
            throw new Exception("The number of characters in a line is not even");
        }

        $countOpened = mb_substr_count($string, '(');
        $countClosed = mb_substr_count($string, ')');

        if ($countOpened > $countClosed) {
            throw new Exception("There are more opening than closing");
        }
        if ($countOpened < $countClosed) {
            throw new Exception("More closing than opening");
        }

        if (stristr($string, ')(')) {
            throw new Exception("Invalid value");
        }

    }
}