<?php
namespace hw6;

class App
{
    public function run()
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo 'IP = ', $_SERVER['SERVER_ADDR'], PHP_EOL;
    }
}