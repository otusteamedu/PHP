<?php

namespace LineProcessing;

class LineProcessing
{
    private string $str;
    private string $len;
    private string $msg;

    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["string"])) {
                $this->str = $_POST["string"];
                $this->len = $_SERVER["CONTENT_LENGTH"];
                $this->msg = "";
            } else {
                throw new \Exception("Установите значение параметра string.");
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            throw new \Exception("Вы пришли методом GET!");
        }
    }

    protected function isValidString(string $brackets, int $length): bool
    {
        if (isset($brackets) && $length - 7 == strlen($brackets)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isBracketsCorrect(string $brackets): bool
    {
        $counter = 0;
        if ($brackets[0] == ")") {
            $this->msg = "Вы не с той скобки ')' начали.";
            return false;
        }
        for ($i = 0; $i < strlen($brackets); $i++) {
            if ($brackets[$i] == '(') {
                $counter++;
            } elseif ($brackets[$i] == ')') {
                $counter--;
            }
        }

        switch ($counter <=> 0) {
            case 0:
                $this->msg = "Скобки сочетаются!";
                return true;
            case 1:
                $this->msg = "Открывающих скобок '(' больше.";
                return false;
            case -1:
                $this->msg = "Закрывающмх скобок ')' больше.";
                return false;
        }
    }

    protected function sendResponse(int $response): void
    {
        switch ($response) {
            case 200:
                header("HTTP/1.1 200 OK");
                echo "Всё хорошо!" . PHP_EOL;
                break;
            case 400:
                header("HTTP/1.1 400 Bad request");
                echo "Всё реально плохо..." . PHP_EOL;
                break;
            default:
                echo "Неверный заголовок";
        }
        echo $this->msg;
    }

    public function run(): bool
    {
        if ($this->isValidString($this->str, $this->len) && $this->isBracketsCorrect($this->str)) {
            $this->sendResponse(200);
            return true;
        } else {
            $this->sendResponse(400);
            return false;
        }
    }
}
