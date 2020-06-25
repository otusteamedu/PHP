<?php

namespace VyacheslavChulkin;

class HelloWorld 
{
    public static function sayHello(string $name = "World"): void
    {
        echo "Hello, $name!";
    }
}