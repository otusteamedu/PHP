<?php

declare(strict_types=1);

use Otus\Homework3;

class App
{
    public function say(): void
    {
        $homework3 = new Homework3();
        echo $homework3->sayHelloWorld();
    }
}
