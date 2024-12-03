<?php

namespace Marchenko;

use Exception;

class Validate
{
    const LENGTH_SIGN_EQUAL = 1;
    const CORRECT_BRACKETS = '()';

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

            if (!empty($_POST)) {
                $this->varName = key($_POST);
            } else {
                throw new Exception("Data was not sent by POST method");
            }

            if (!empty($_POST[$this->varName])) {
                $this->value = $_POST[$this->varName];
            } else {
                throw new Exception("Variable \"$this->varName\" is empty");
            }

            $condition = strlen($this->varName) + strlen($this->value) + Validate::LENGTH_SIGN_EQUAL !=
                $this->contentLength;
            if ($condition) {
                throw new Exception("Content-Length is wrong.");
            }
            $this->checkBracket();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request ' . $e->getMessage(), false, 400);
            exit();
        }
    }

    protected function checkBracket()
    {
        $numIteration = strlen($this->value) / 2;
        if (!is_integer($numIteration)) {
            throw new Exception("Unpaired number of brackets");
        }
        $i = 0;
        $value = $this->value;
        while ($value != '') {
            $i++;
            $value = str_replace(Validate::CORRECT_BRACKETS, '', $value);
            if ($i > $numIteration) {
                throw new Exception("Sequence of brackets is broken");
            }
        }
    }
}
