<?php


namespace Src;


class App
{
    public $string;

    public function __construct()
    {
        $this->string = $_POST('string');
    }

    public function run()
    {
        $validator = new Validator($this->string);
        if ($validator->validateBrackets()) {
            header("HTTP/1.0 200 Ok");
            echo 'Все ок' . PHP_EOL;
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo 'Все плохо' . PHP_EOL;
        }
    }
}