<?php


namespace Src;

use http\Exception\RuntimeException;

class Parser
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function parse()
    {
        $this->parseString($this->string);
    }

    private function parseString($string)
    {
        $len = strlen($string);
        $stack = [];
        try {
            for ($i = 0; $i < $len; $i++) {
                switch ($string[$i]) {
                    case '(':
                        array_push($stack, 0);
                        break;
                    case ')':
                        if (array_pop($stack) !== 0)
                            throw new RuntimeException('Все плохо');
                        break;
                    default:
                        break;
                }
            }
            if (empty($stack)) {
                header("HTTP/1.0 200 Ok");
                echo 'Все ок' . PHP_EOL;
            } else {
                header("HTTP/1.1 400 Bad Request");
                echo 'Все плохо' . PHP_EOL;
            };
        } catch (\Exception $exception) {
            header("HTTP/1.1 400 Bad Request");
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}