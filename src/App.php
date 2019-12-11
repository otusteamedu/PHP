<?php

declare(strict_types=1);

use Otus\Homework3;

class App
{
    public function sayToMe(string $name = ''): void
    {
        $homework3 = new Homework3();

        echo $homework3->sayHelloWorld();
        echo PHP_EOL;
        echo $homework3->sayHello($name);
    }
}
