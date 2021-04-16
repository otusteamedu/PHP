<?php


namespace App\Console;



use App\Utils\Config;



class App extends Console
{

    /**
     * App constructor.
     */
    public function __construct()
    {
    }

    public function run()
    {
        echo 'Hello from ' . self::class, PHP_EOL;

    }

}

