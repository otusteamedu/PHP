<?php
namespace APirozhkov\Test;

class MyClass
{
    public function getHttpClient() {
        return $_SERVER['HTTP_HOST'];
    }
}