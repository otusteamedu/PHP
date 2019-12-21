<?php

declare(strict_types=1);

class App
{
    public function run(): void
    {
        echo $_SERVER['SERVER_ADDR'];
    }
}
