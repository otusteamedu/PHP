<?php

namespace Marchenko;

use Exception;

class Validate
{
    const LENGTH_SIGN_EQUAL = 1;
    private $contentLength;
    private $varName;
    private $value;

    public function __construct()
    {
        try {
            if (!empty($_SERVER["CONTENT_LENGTH"])) {
                $this->contentLength = $_SERVER["CONTENT_LENGTH"];
            } else {
                throw new Exception("Header Content-Length is empty.");
            }

//            var_dump($this->contentLength);

            if (!empty($_POST)) {
                $this->varName = key($_POST);
            } else {
                throw new Exception("Data was not sent by POST method");
            }

//            var_dump($this->varName);

            if (!empty($_POST[$this->varName])) {
                $this->value = $_POST[$this->varName];
            } else {
                throw new Exception("Variable \"$this->varName\" is empty");
            }
//            var_dump($this->value);


            $condition = strlen($this->varName) + strlen($this->value) + Validate::LENGTH_SIGN_EQUAL !=
                $this->contentLength;
//            var_dump($condition);
            if ($condition) {
                throw new Exception("Content-Length is wrong.");
            }

        } catch (Exception $e) {
//            http_response_code(400);
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request ' . $e->getMessage(), false, 400);
        }
    }

//    protected function checkBracket(string $value)
//    {
//        $buf = [];
//        foreach ($value as $sign) {
//            echo $sign . PHP_EOL;
//        }
//    }

}